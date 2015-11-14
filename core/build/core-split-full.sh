git subsplit init http://yobi.xehub.io:8888/xeteam/core
git subsplit publish --heads="master routing-develop" src/Xpressengine/Routing:http://yobi.xehub.io:8888/xeteam/xpressengine3-routing
git subsplit publish --heads="master menu-develp" src/Xpressengine/Menu:http://yobi.xehub.io:8888/xeteam/xpressengine3-menu
#git subsplit publish --heads="master interception-develop" src/Xpressengine/Interception:http://yobi.xehub.io:8888/xeteam/xpressengine3-interception
#git subsplit publish --heads="master event-develop" src/Xpressengine/Event:http://yobi.xehub.io:8888/xeteam/xpressengine3-event
#git subsplit publish --heads="master widget-develop" src/Xpressengine/Widget:http://yobi.xehub.io:8888/xeteam/xpressengine3-widget
#git subsplit publish --heads="master skin-develop" src/Xpressengine/Skin:http://yobi.xehub.io:8888/xeteam/xpressengine3-skin
#git subsplit publish --heads="master uiobject-develop" src/Xpressengine/UIObject:http://yobi.xehub.io:8888/xeteam/xpressengine3-uiobject
#git subsplit publish --heads="master plugin-develop" src/Xpressengine/Plugin:http://yobi.xehub.io:8888/xeteam/xpressengine3-plugin
git subsplit publish --heads="master document-develop" src/Xpressengine/Document:http://yobi.xehub.io:8888/xeteam/xpressengine3-document
git subsplit publish --heads="master dynamicField-develop" src/Xpressengine/DynamicField:http://yobi.xehub.io:8888/xeteam/xpressengine3-dynamicField
git subsplit publish --heads="master database-develop" src/Xpressengine/Database:http://yobi.xehub.io:8888/xeteam/xpressengine3-database
git subsplit publish --heads="master config-develop" src/Xpressengine/Config:http://yobi.xehub.io:8888/xeteam/xpressengine3-config
git subsplit publish --heads="master member-develop" src/Xpressengine/Member:http://yobi.xehub.io:8888/xeteam/xpressengine3-member
git subsplit publish --heads="master permission-develop" src/Xpressengine/Permission:http://yobi.xehub.io:8888/xeteam/xpressengine3-permission
git subsplit publish --heads="master taxonomy-develop" src/Xpressengine/Taxonomy:http://yobi.xehub.io:8888/xeteam/xpressengine3-taxonomy
git subsplit publish --heads="master storage-develop" src/Xpressengine/Storage:http://yobi.xehub.io:8888/xeteam/xpressengine3-storage
git subsplit publish --heads="master media-develop" src/Xpressengine/Media:http://yobi.xehub.io:8888/xeteam/xpressengine3-media
git subsplit publish --heads="master undo-develop" src/Xpressengine/Undo:http://yobi.xehub.io:8888/xeteam/xpressengine3-undo
git subsplit publish --heads="master keygen-develop" src/Xpressengine/Keygen:http://yobi.xehub.io:8888/xeteam/xpressengine3-keygen
rm -rf .subsplit/
