git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master permission-develop" src/Xpressengine/Permission:http://yobi.xehub.io:8888/xeteam/xpressengine3-permission
rm -rf .subsplit/
