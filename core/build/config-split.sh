git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master config-develop" src/Xpressengine/Config:http://yobi.xehub.io:8888/xeteam/xpressengine3-config
rm -rf .subsplit/
