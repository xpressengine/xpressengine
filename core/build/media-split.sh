git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master media-develop" src/Xpressengine/Media:http://yobi.xehub.io:8888/xeteam/xpressengine3-media
rm -rf .subsplit/
