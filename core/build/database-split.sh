git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master database-develop" src/Xpressengine/database:http://yobi.xehub.io:8888/xeteam/xpressengine3-database
rm -rf .subsplit/
