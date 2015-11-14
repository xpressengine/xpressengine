git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master menu-develop" src/Xpressengine/Routing:http://yobi.xehub.io:8888/xeteam/xpressengine3-menu
rm -rf .subsplit/
