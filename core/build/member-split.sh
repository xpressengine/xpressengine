git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master member-develop" src/Xpressengine/Member:http://yobi.xehub.io:8888/xeteam/xpressengine3-member
rm -rf .subsplit/
