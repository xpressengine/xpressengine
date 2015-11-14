git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master taxonomy-develop" src/Xpressengine/Taxonomy:http://yobi.xehub.io:8888/xeteam/xpressengine3-taxonomy
rm -rf .subsplit/
