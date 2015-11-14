git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master dynamicField-develop" src/Xpressengine/DynamicField:http://yobi.xehub.io:8888/xeteam/xpressengine3-DynamicField
rm -rf .subsplit/
