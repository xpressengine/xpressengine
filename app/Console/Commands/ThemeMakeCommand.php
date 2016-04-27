<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class ThemeMakeCommand extends Command
{

    protected $signature = 'make:theme
                        {file : The path of Theme class file}
                        {class : The name of Theme class}
                        {title : The title of the Theme}
                        {--id= : The path of Theme class file}
                        {--description= : The description of the Theme}
                        {--template= : The path of main template file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new theme of XpressEngine';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    protected $originComposerStr = null;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        // resolve parameters
        $file = $this->getThemeFile();
        list($namespace, $class) = $this->getThemeClass();
        $plugin = $this->getTargetPlugin($file);
        $id = $this->getThemeId($plugin, $file);
        $title = $this->getThemeTitle();
        $description = $this->getThemeDescription($id, $plugin);
        $templateView = strtolower(last(explode('@',$id)));
        $template = $this->getTemplatePath($templateView, $plugin);
        $css = $this->getCssPath($id, $plugin);

        // print and confirm the information of theme
        if($this->confirmInfo($file, $namespace.'\\'.$class, $plugin, $id, $title, $description, $template, $css) === false){
            return false;
        }

        try {
            // theme class 파일 생성
            $this->makeThemeClass($file, $namespace, $class, $plugin, $template, $templateView, $css);
            $this->makeTemplate($plugin, $template);
            $this->makeCss($plugin, $css);

            // composer.json 파일 수정
            if($this->registerTheme($plugin, 'theme/'.$id, $namespace.'\\'.$class, $title, $description) === false) {
                throw new \Exception('Writing to composer.json file was failed.');
            }

        } catch (\Exception $e) {
            $this->clean($file, $plugin, $template, $css);
            throw $e;
        }

        $this->info("Theme is created successfully.");

        //$this->info("See ./plugins/$name directory. And open $url in your browser.");
        //$this->info("Input and modify your plugin information in ./plugins/$name/composer.json file.");
    }

    /**
     * makeDirectory
     *
     * @param $path
     *
     * @return void
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
    }

    /**
     * Build the class with the given name.
     *
     * @return string
     */
    protected function buildThemeCode($namespace, $class, $plugin, $template, $templateView, $css)
    {
        $pluginClass = \App::make('xe.plugin')->getPlugin($plugin)->getClass();
        list($pluginNamespace, $pluginClass) = $this->parseClassName($pluginClass);

        $stub = $this->files->get($this->getStub('theme.stub'));

        /*
         * DummyNamespace
         * DummyPluginNamespace
         * DummyPlugin
         * DummyClass
         * DummyTemplateFile
         * DummyTemplateView
         * DummyCssFile
        */

        if($class === $pluginClass) {
            $pluginClass = $pluginClass.'Plugin';
        }

        $this->replaceCode($stub, 'DummyNamespace', $namespace)
            ->replaceCode($stub, 'DummyClass', $class)
            ->replaceCode($stub, 'DummyPluginNamespace', $pluginNamespace)
            ->replaceCode($stub, 'DummyPluginClass', $pluginClass)
            ->replaceCode($stub, 'DummyTemplateFile', $template)
            ->replaceCode($stub, 'DummyTemplateView', 'views.theme.'.$templateView)
            ->replaceCode($stub, 'DummyCssFile', $css)
            ->replaceCode($stub, 'DummyCssFile', 'assets/css/theme.'.strtolower($class).'.css');

        return $stub;
    }

    /**
     * replaceCode
     *
     * @param $stub
     * @param $search
     * @param $replace
     *
     * @return $this
     */
    protected function replaceCode(&$stub, $search, $replace)
    {
        $stub = str_replace($search, $replace, $stub);
        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub($filename)
    {
        return __DIR__.'/stubs/'.$filename;
    }

    /**
     * getThemeId
     *
     * @param $plugin
     * @param $file
     *
     * @return array|string
     * @throws \Exception
     */
    protected function getThemeId($plugin, $file)
    {
        $id = $this->option('id');

        if(!$id) {
            $fileName = basename($file,'.php');
            $id = $plugin.'@'.strtolower($fileName);
        } else {
            if(strpos('theme/', $id) === 0) {
                $id = substr($id, 6);
            }

            if(strpos($id, '@') === false) {
                $id = $plugin.'@'.$id;
            }
        }

        $theme = \App::make('xe.theme')->getTheme($id);

        if($theme !== null) {
            throw new \Exception("Theme[$theme] already exists.");
        }

        return $id;
    }

    /**
     * getTargetPlugin
     *
     * @param $file
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getTargetPlugin($file)
    {
        $paths = explode('/', $file);

        if($paths[0] === str_replace(base_path().'/', '', app('xe.plugin')->getPluginsDir())) {
            array_shift($paths);
        }

        $plugin = array_shift($paths);

        if(app('xe.plugin')->getPlugin($plugin) === null) {
            throw new \Exception("Unable to find a plugin to locate the theme file. plugin[$plugin] is not found.");
        }

        return $plugin;
    }

    /**
     * getThemeTitle
     *
     * @return array|string
     */
    protected function getThemeTitle()
    {
        return $this->argument('title');
    }

    /**
     * getThemeDescription
     *
     * @param $id
     * @param $plugin
     *
     * @return array|string
     */
    protected function getThemeDescription($id, $plugin)
    {
        $description = $this->option('description');
        if(!$description) {
            $description = sprintf(
                '%s theme from %s plugin.',
                ucfirst(last(explode('@', $id))), ucfirst($plugin)
            );
        }
        return $description;
    }

    /**
     * getThemeFile
     *
     * @return array|string
     * @throws \Exception
     */
    protected function getThemeFile()
    {
        $filePath = $this->argument('file');
        if(file_exists($filePath)) {
            throw new \Exception("file[$filePath] already exists.");
        }
        return $filePath;
    }

    /**
     * getTemplatePath
     *
     * @param $id
     * @param $plugin
     *
     * @return string
     * @throws \Exception
     */
    protected function getTemplatePath($id, $plugin)
    {
        $entity = \App::make('xe.plugin')->getPlugin($plugin);
        $viewFile = 'views/theme/'.$id.'.blade.php';
        if(file_exists($entity->getPath($viewFile))) {
            throw new \Exception("template file[views/$viewFile] already exists.");
        }
        return $viewFile;
    }

    /**
     * getCssPath
     *
     * @param $id
     * @param $plugin
     *
     * @return string
     * @throws \Exception
     */
    protected function getCssPath($id, $plugin)
    {
        $entity = \App::make('xe.plugin')->getPlugin($plugin);
        $file = strtolower(last(explode('@',$id)));
        $cssFile = 'assets/theme/'.$file.'.css';
        if(file_exists($entity->getPath($cssFile))) {
            throw new \Exception("template file[views/$cssFile] already exists.");
        }
        return $cssFile;
    }

    /**
     * confirmInfo
     *
     * @param $file
     * @param $class
     * @param $plugin
     * @param $id
     * @param $title
     * @param $description
     * @param $template
     * @param $css
     *
     * @return bool
     */
    protected function confirmInfo($file, $class, $plugin, $id, $title, $description, $template, $css)
    {
        $this->info(
            sprintf("[New theme info]
class file: %s
class name: %s
plugin: %s
id: %s
title: %s
description: %s
template file: %s
css file: %s",
                $file, $class, $plugin, $id, $title, $description, $template, $css
            )
        );

        while($confirm = $this->ask('Do you want to add theme? [yes|no]')) {
            if($confirm === 'yes') {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * getThemeClass
     *
     * @return array
     */
    protected function getThemeClass()
    {
        $class = $this->argument('class');
        return $this->parseClassName($class);
    }

    /**
     * makeThemeClass
     *
     * @param $file
     * @param $namespace
     * @param $class
     * @param $plugin
     * @param $template
     *
     * @return void
     * @throws \Exception
     */
    protected function makeThemeClass($file, $namespace, $class, $plugin, $template, $templateView, $css)
    {
        $code = $this->buildThemeCode($namespace, $class, $plugin, $template, $templateView, $css);

        $this->makeDirectory(base_path(dirname($file)));

        $this->files->put(base_path($file), $code);

        if(!class_exists($namespace.'\\'.$class)) {
            $this->files->delete(base_path($file));
            throw new \Exception("Unable to load the theme class file[$file]. please check autoload setting of composer.json");
        }
    }

    /**
     * parseClassName
     *
     * @param $class
     * @param $m
     *
     * @return array
     */
    protected function parseClassName($class)
    {
        $namespace = preg_replace('|\\\\[^\\\\]*$|', '', $class);
        $namespace = str_replace('\\\\', '\\', $namespace);
        $namespace = trim($namespace, '\\');

        preg_match('|[^\\\\]*$|', $class, $m);
        $class = $m[0];
        return [$namespace, $class];
    }

    /**
     * formatJson
     *
     * @param      $json
     * @param bool $unescapeUnicode
     * @param bool $unescapeSlashes
     *
     * @return string
     */
    public function formatJson($json, $unescapeUnicode = true, $unescapeSlashes = true)
    {
        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '    ';
        $newLine = "\n";
        $outOfQuotes = true;
        $buffer = '';
        $noescape = true;

        for ($i = 0; $i < $strLen; $i++) {
            // Grab the next character in the string
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ('"' === $char && $noescape) {
                $outOfQuotes = !$outOfQuotes;
            }

            if (!$outOfQuotes) {
                $buffer .= $char;
                $noescape = '\\' === $char ? !$noescape : true;
                continue;
            } elseif ('' !== $buffer) {
                if ($unescapeSlashes) {
                    $buffer = str_replace('\\/', '/', $buffer);
                }

                if ($unescapeUnicode && function_exists('mb_convert_encoding')) {
                    // https://stackoverflow.com/questions/2934563/how-to-decode-unicode-escape-sequences-like-u00ed-to-proper-utf-8-encoded-cha
                    $buffer = preg_replace_callback('/(\\\\+)u([0-9a-f]{4})/i', function ($match) {
                        $l = strlen($match[1]);

                        if ($l % 2) {
                            return str_repeat('\\', $l - 1) . mb_convert_encoding(
                                pack('H*', $match[2]),
                                'UTF-8',
                                'UCS-2BE'
                            );
                        }

                        return $match[0];
                    }, $buffer);
                }

                $result .= $buffer.$char;
                $buffer = '';
                continue;
            }

            if (':' === $char) {
                // Add a space after the : character
                $char .= ' ';
            } elseif (('}' === $char || ']' === $char)) {
                $pos--;
                $prevChar = substr($json, $i - 1, 1);

                if ('{' !== $prevChar && '[' !== $prevChar) {
                    // If this character is the end of an element,
                    // output a new line and indent the next line
                    $result .= $newLine;
                    for ($j = 0; $j < $pos; $j++) {
                        $result .= $indentStr;
                    }
                } else {
                    // Collapse empty {} and []
                    $result = rtrim($result);
                }
            }

            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line
            if (',' === $char || '{' === $char || '[' === $char) {
                $result .= $newLine;

                if ('{' === $char || '[' === $char) {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
        }

        return $result;
    }

    /**
     * registerTheme
     *
     * @param $plugin
     * @param $id
     * @param $class
     * @param $title
     * @param $description
     *
     * @return int
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function registerTheme($plugin, $id, $class, $title, $description)
    {
        $pluginEntity = \App::make('xe.plugin')->getPlugin($plugin);
        $composerStr = $this->files->get($pluginEntity->getPath('composer.json'));
        $this->originComposerStr = $composerStr;
        $json = json_decode($composerStr, true);
        $component = data_get($json, 'extra.xpressengine.component');
        if(isset($component[$id])) {
            throw new \Exception(sprintf('component[%s] already exists.', $id));
        }
        $component[$id] = [];
        $component[$id]['class'] = $class;
        $component[$id]['name'] = $title;
        $component[$id]['description'] = $description;
        array_set($json, 'extra.xpressengine.component', $component);

        $json = $this->formatJson(json_encode($json));

        return $this->files->put($pluginEntity->getPath('composer.json'), $json);
    }

    /**
     * makeTemplate
     *
     * @param $plugin
     * @param $template
     *
     * @return bool
     */
    protected function makeTemplate($plugin, $template)
    {
        $pluginEntity = \App::make('xe.plugin')->getPlugin($plugin);
        $file = $pluginEntity->getPath($template);
        $this->makeDirectory(dirname($file));
        return $this->files->copy($this->getStub('theme.blade.stub'), $file);
    }

    /**
     * makeCss
     *
     * @param $plugin
     * @param $css
     *
     * @return bool
     */
    protected function makeCss($plugin, $css)
    {
        $pluginEntity = \App::make('xe.plugin')->getPlugin($plugin);
        $file = $pluginEntity->getPath($css);
        $this->makeDirectory(dirname($file));
        return $this->files->copy($this->getStub('theme.css.stub'), $file);
    }

    /**
     * clean
     *
     * @param $file
     * @param $plugin
     * @param $template
     * @param $css
     *
     * @return void
     */
    protected function clean($file, $plugin, $template, $css)
    {
        // delete theme class file
        if(is_writable(base_path($file))) {
            $this->files->delete(base_path($file));
        }

        $pluginEntity = \App::make('xe.plugin')->getPlugin($plugin);

        // unregister component from composer.json
        $composerFile = $pluginEntity->getPath('composer.json');
        if($this->originComposerStr !== null && is_writable($composerFile)) {
            $this->files->put($composerFile, $this->originComposerStr);
        }

        // delete template file
        $templateFile = $pluginEntity->getPath($template);
        if(is_writable($templateFile)) {
            $this->files->delete($templateFile);
        }

        // delete css file
        $cssFile = $pluginEntity->getPath($css);
        if(is_writable($cssFile)) {
            $this->files->delete($cssFile);
        }
    }


}
