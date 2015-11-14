git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master document-develop" src/Xpressengine/Document:http://yobi.xehub.io:8888/xeteam/xpressengine3-document
rm -rf .subsplit/
