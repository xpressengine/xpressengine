<?php
/**
 * UserMigration.php
 *
 * PHP version 7
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use DB;
use Schema;
use XeLang;
use Xpressengine\Support\Migration;
use Xpressengine\User\Models\User;
use Xpressengine\User\UserRegisterHandler;

/**
 * Class UserMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('user ID');
            $table->string('display_name', 255)->comment('display name.');
            $table->string('email', 255)->nullable()->comment('email');
            $table->string('login_id', 255)->unique()->comment('id');
            $table->string('password', 255)->nullable()->comment('password');
            $table->string('rating', 15)->default('user')->comment('user rating. guest/user/manager/super');
            $table->string('status', 20)->comment('account status. activated/deactivated');
            $table->text('introduction')->default(null)->nullable()->comment('user introduction');
            $table->string('profile_image_id', 36)->nullable()->comment('profile image file ID');
            $table->string('remember_token', 255)->nullable()->comment('token for keep login');
            $table->timestamp('login_at')->nullable()->comment('login date');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->index()->comment('updated date');
            $table->timestamp('password_updated_at')->nullable()->comment('password updated date');

            $table->primary('id');
        });
        Schema::create('user_group', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('group ID');
            $table->string('name')->comment('group name');
            $table->string('description', 1000)->comment('group description');
            $table->integer('order')->default(0)->index()->comment('order number');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->primary('id');
        });

        Schema::create('user_group_user', function (Blueprint $table) {
            // user IDs included in the use group
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('group_id', 36)->comment('group ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->timestamp('created_at')->nullable()->comment('created date');

            $table->unique(['group_id', 'user_id']);
            $table->index('group_id');
            $table->index('user_id');
        });

        Schema::create('user_account', function (Blueprint $table) {
            // user account. Login via account information provided by other providers. As like OAuth.
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('ID');
            $table->string('user_id')->comment('user ID');
            $table->string('account_id')->comment('account Id');
            $table->string('email')->nullable()->comment('email');
            $table->char('provider', 20)->comment('OAuth provider. naver/twitter/facebook/...');
            $table->string('token', 500)->comment('token');
            $table->string('token_secret', 500)->comment('token secret');
            $table->timestamp('created_at')->nullable()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->primary('id');
            $table->unique(['provider', 'account_id']);
        });

        Schema::create('user_email', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->string('address')->comment('email address');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->index('user_id');
            $table->index('address');
        });

        Schema::create('user_pending_email', function (Blueprint $table) {
            // email confirm
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->string('address')->comment('email address');
            $table->string('confirmation_code')->nullable()->comment('confirmation code');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->index('user_id');
            $table->index('address');
        });

        Schema::create('user_password_resets', function (Blueprint $table) {
            // find account password
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('email')->index()->comment('email address');
            $table->string('token')->index()->comment('token');
            $table->timestamp('created_at')->nullable()->comment('created date');
        });

        Schema::create('user_register_token', function (Blueprint $table) {
            // find account password
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('user ID');
            $table->string('guard', 100)->comment('the guard creating token');
            $table->text('data')->comment('token data');
            $table->timestamp('created_at')->nullable()->comment('created date');
        });

        Schema::create('user_terms', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('title');
            $table->string('content')->nullable();
            $table->string('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_require')->default(true);

            $table->primary('id');
            $table->engine = "InnoDB";
        });

        Schema::create('user_login_log', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id')->comment('row id');
            $table->string('user_id', 36)->comment('user ID');
            $table->string('user_agent')->comment('user agent');
            $table->string('ip', 15)->comment('ip');
            $table->timestamp('created_at')->nullable()->comment('created date');

            $table->index('user_id');
        });

        $this->createUserTermAgreeTable();
    }

    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed()
    {
        DB::table('config')->insert([
            ['name' => 'user', 'vars' => '[]'],
            ['name' => 'user.common', 'vars' => '{"useCaptcha":false,"webmasterName":"webmaster","webmasterEmail":"webmaster@domain.com"}'],
            ['name' => 'user.register', 'vars' => '{"secureLevel":"low","joinable":true,"register_process":"activated","term_agree_type":"pre","display_name_unique":false,"use_display_name":true,"password_rules":"min:6|alpha|numeric|special_char"}'],
            ['name' => 'toggleMenu@user', 'vars' => '{"activate":["user\/toggleMenu\/xpressengine@profile","user\/toggleMenu\/xpressengine@manage"]}']
        ]);
    }

    /**
     * Run after service activation.
     *
     * @return void
     */
    public function init()
    {
        $registerConfig = app('xe.config')->get('user.register');

        // add default user groups
        $joinGroup = app('xe.user')->groups()->create(
            [
                'name' => '정회원',
                'description' => 'default user group'
            ]
        );
        app('xe.user')->groups()->create(
            [
                'name' => '준회원',
                'description' => 'sub user group'
            ]
        );
        $registerConfig->set('joinGroup', $joinGroup->id);

        $displayNameCaption = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "닉네임";
            if ($locale != 'ko') {
                $value = "Nickname";
            }
            XeLang::save($displayNameCaption, $locale, $value);
        }
        $registerConfig->set('display_name_caption', $displayNameCaption);

        app('xe.config')->modify($registerConfig);

        // set admin's group
        auth()->user()->joinGroups($joinGroup);
    }

    /**
     * check updated
     *
     * @param null $installedVersion installed version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        if ($this->checkNeedMergeConfig() == true) {
            return false;
        }

        if ($this->checkExistRegisterConfig() == false) {
            return false;
        }

        if ($this->checkNeedAddTermTableColumns() === false) {
            return false;
        }

        if ($this->checkExistUserTermAgreeTable() === false) {
            return false;
        }

        if ($this->checkExistUserLoginIdColumn() === false) {
            return false;
        }

        return true;
    }

    /**
     * run update
     *
     * @param null $installedVersion installed version
     *
     * @return void
     */
    public function update($installedVersion = null)
    {
        if ($this->checkNeedMergeConfig() == true) {
            $this->mergeConfig();
        }

        if ($this->checkExistRegisterConfig() == false) {
            $this->divideRegisterConfig();
        }

        if ($this->checkNeedAddTermTableColumns() === false) {
            $this->addTermTableColumns();
            $this->updateOldTermsRequire();
        }

        if ($this->checkExistUserTermAgreeTable() === false) {
            $this->createUserTermAgreeTable();
        }

        //TODO 실행 조건 추가
        $this->deleteDisplayNameUnique();

        if ($this->checkExistUserLoginIdColumn() === false) {
            $this->createUserLoginIdColumn();
            $this->migrationLoginIdColumn();
            $this->setLoginIdColumnUnique();
        }
    }

    /**
     * check need user setting merge(common, join)
     *
     * @return bool
     */
    private function checkNeedMergeConfig()
    {
        return app('xe.config')->get('user.join') !== null;
    }

    /**
     * run user setting merge(common, join)
     *
     * @return void
     */
    private function mergeConfig()
    {
        $commonConfig = app('xe.config')->get('user.common');
        $joinConfig = app('xe.config')->get('user.join');

        $commonConfigAttribute = $commonConfig->getPureAll();
        $joinConfigAttribute = $joinConfig->getPureAll();

        foreach ($joinConfigAttribute as $name => $value) {
            $commonConfigAttribute[$name] = $value;
        }

        app('xe.config')->put('user.common', $commonConfigAttribute);
        app('xe.config')->remove($joinConfig);
    }

    /**
     * check exist register config
     *
     * @return bool
     */
    private function checkExistRegisterConfig()
    {
        return app('xe.config')->get('user.register') !== null;
    }

    /**
     * divide from user.common to user.register
     *
     * @return void
     */
    private function divideRegisterConfig()
    {
        $commonConfig = app('xe.config')->get('user.common');
        $originalCommonConfigAttribute = $commonConfig->getPureAll();

        $commonConfigAttribute = ['useCaptcha', 'webmasterName', 'webmasterEmail'];
        $registerConfigAttribute = array_diff_key($originalCommonConfigAttribute, array_flip($commonConfigAttribute));

        $newCommonConfigAttribute = [];
        foreach ($commonConfigAttribute as $config) {
            if (isset($originalCommonConfigAttribute[$config]) === true) {
                $newCommonConfigAttribute[$config] = $originalCommonConfigAttribute[$config];
            }
        }

        if (isset($registerConfigAttribute['guard_forced']) && $registerConfigAttribute['guard_forced'] === true) {
            $registerConfigAttribute['register_process'] = User::STATUS_PENDING_EMAIL;
        } else {
            $registerConfigAttribute['register_process'] = User::STATUS_ACTIVATED;
        }
        unset($registerConfigAttribute['guard_forced']);

        $registerConfigAttribute['term_agree_type'] = UserRegisterHandler::TERM_AGREE_PRE;
        $registerConfigAttribute['display_name_unique'] = true;
        $registerConfigAttribute['use_display_name'] = true;
        $registerConfigAttribute['dynamic_fields'] = array_keys(app('xe.dynamicField')->gets('user'));

        $displayNameCaption = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "닉네임";
            if ($locale != 'ko') {
                $value = "Nickname";
            }
            XeLang::save($displayNameCaption, $locale, $value);
        }
        $registerConfigAttribute['display_name_caption'] = $displayNameCaption;

        $passwordRuleLevel = app('config')->get('xe.user.password.default');
        $registerConfigAttribute['password_rules'] = app('config')->get("xe.user.password.levels.{$passwordRuleLevel}");
        if (isset($registerConfigAttribute['secureLevel']) === true) {
            unset($registerConfigAttribute['secureLevel']);
        }

        app('xe.config')->put('user.common', $newCommonConfigAttribute);
        app('xe.config')->set('user.register', $registerConfigAttribute);
    }

    /**
     * Check need term table update
     *
     * @return bool
     */
    private function checkNeedAddTermTableColumns()
    {
        return Schema::hasColumn('user_terms', 'is_require') && Schema::hasColumn('user_terms', 'description');
    }

    /**
     * Add term table description, is_require columns
     *
     * @return void
     */
    private function addTermTableColumns()
    {
        Schema::table('user_terms', function (Blueprint $table) {
            $table->string('description')->after('title')->nullable();
            $table->boolean('is_require')->default(true)->nullable();
        });
    }

    /**
     * Old term update require
     *
     * @return void
     */
    private function updateOldTermsRequire()
    {
        \DB::table('user_terms')->update(['is_require' => true]);
    }

    /**
     * Check exist user term agree table
     *
     * @return bool
     */
    private function checkExistUserTermAgreeTable()
    {
        return Schema::hasTable('user_term_agrees');
    }

    /**
     * Create user term agree table
     *
     * @return void
     */
    private function createUserTermAgreeTable()
    {
        Schema::create('user_term_agrees', function (Blueprint $table) {
            $table->string('id', 36);

            $table->string('user_id', 36);
            $table->string('term_id', 36);

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['user_id', 'term_id']);
            $table->index('user_id');
            $table->index('term_id');
        });
    }

    /**
     * display_name field unique 삭제
     *
     * @return void
     */
    private function deleteDisplayNameUnique()
    {
        try {
            Schema::table('user', function (Blueprint $table) {
                $table->dropUnique('user_display_name_unique');
            });
        } catch (\Exception $e) {
        }
    }

    /**
     * User 테이블에 login_id 컬럼이 존재 여부 확인
     *
     * @return bool
     */
    private function checkExistUserLoginIdColumn()
    {
        return Schema::hasColumn('user', 'login_id');
    }

    /**
     * User 테이블에 login_id 컬럼 생성
     *
     * @return void
     */
    private function createUserLoginIdColumn()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('login_id')->after('email');
        });
    }

    /**
     * user email에서 계정을 login_id로 update
     * 중복된 login_id는 확인해서 login_id 뒤에 index를 붙임
     *
     * @return void
     */
    private function migrationLoginIdColumn()
    {
        \DB::table('user')->update(['login_id' =>  \DB::raw("REPLACE(SUBSTRING_INDEX(email, '@', 1), '.', '')")]);

        $duplicateEmails = \DB::table('user')->select('login_id')
            ->groupBy('login_id')->havingRaw('count(login_id) > 1')->get();
        foreach ($duplicateEmails as $duplicateEmail) {
            $duplicateUsers = User::where('login_id', $duplicateEmail->login_id)->orderBy('created_at')->get();
            foreach ($duplicateUsers as $index => $duplicateUser) {
                $duplicateUser->login_id .= ($index + 1);
                $duplicateUser->save();
            }
        }
    }

    /**
     * login_id 업데이트 후 unique 지정
     *
     * @return void
     */
    private function setLoginIdColumnUnique()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->unique('login_id');
        });
    }
}
