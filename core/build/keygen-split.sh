git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master keygen-develop" src/Xpressengine/Keygen:http://yobi.xehub.io:8888/xeteam/xpressengine3-keygen
rm -rf .subsplit/
