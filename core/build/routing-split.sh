git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master routing-develop" src/Xpressengine/Routing:http://yobi.xehub.io:8888/xeteam/xpressengine3-routing
rm -rf .subsplit/
