/**
 * Created by lingjianfeng on 15/2/20.
 */

var ChooseHeadLayer = cc.LayerColor.extend({
    manHead1 : null,
    manHead2 : null,
    woManHead1 : null,
    woManHead2 : null,
    boxInfo : null,
    selectIndex : 0,
    ctor : function(){
        this._super(cc.color(0, 255, 255, 255), GC.w, GC.h2);
        this.loadConfig;
        this.loadInit();
        this.loadChooseHead();
        this.loadBoxInfo();
        this.loadBegan();
        this.loadLisenter();
    },
    loadConfig : function(){
    },
    loadInit : function(){
    },
    loadLisenter : function(){
        var listener = cc.EventListener.create({
            event : cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches : true,
            onTouchBegan : function(touch, event){
                return true;
            }
        });
        cc.eventManager.addListener(listener, this);
    },
    loadChooseHead : function(){
        var offsetX = 80;
        this.manHead1 = new cc.Sprite("statics/js/res/GamePlay/man1.png");
        this.addChild(this.manHead1);
        this.manHead1.tag = 0;
        this.manHead1.setPosition(this.width / 2 - this.manHead1.width / 2 - offsetX, this.height * 0.9 - this.manHead1.height / 2);

        this.manHead2 = new cc.Sprite(res.manHead2_png);
        this.addChild(this.manHead2);
        this.manHead2.tag = 1;
        this.manHead2.setPosition(this.width / 2 + this.manHead1.width / 2 + offsetX, this.height * 0.9 - this.manHead1.height / 2);

        this.woManHead1 = new cc.Sprite(res.woManHead1_png);
        this.addChild(this.woManHead1);
        this.woManHead1.tag = 2;
        this.woManHead1.setPosition(this.width / 2 - this.manHead1.width / 2 - offsetX, this.height * 0.5 - this.manHead1.height / 2);

        this.woManHead2 = new cc.Sprite(res.woManHead2_png);
        this.addChild(this.woManHead2);
        this.woManHead2.tag = 3;
        this.woManHead2.setPosition(this.width / 2 + this.manHead1.width / 2 + offsetX, this.height * 0.5 - this.manHead1.height / 2);

        var listener = cc.EventListener.create({
            event : cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches : true,
            onTouchBegan : function(touch, event){
                var target = event.getCurrentTarget();
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var size = target.getContentSize();
                var rect = cc.rect(0, 0, size.width, size.height);
                if (!(cc.rectContainsPoint(rect, locationInNode))) {
                    return false;
                }

                return true;
            },
            onTouchEnded: function (touch, event) {
                var target = event.getCurrentTarget();
                target.parent.selectIndex = target.tag;
                target.parent.boxInfo.setPosition(target.getPosition());
            }
        });
        cc.eventManager.addListener(listener, this.manHead1);
        cc.eventManager.addListener(listener.clone(), this.manHead2);
        cc.eventManager.addListener(listener.clone(), this.woManHead1);
        cc.eventManager.addListener(listener.clone(), this.woManHead2);
    },
    loadBoxInfo : function(){
//        cc.spriteFrameCache.addSpriteFrame(res.box_plist);
        cc.spriteFrameCache.addSpriteFrame("statics/js/res/GamePlay/box1.png", "box1.png");
        cc.spriteFrameCache.addSpriteFrame("statics/js/res/GamePlay/box2.png", "box2.png");
        cc.spriteFrameCache.addSpriteFrame("statics/js/res/GamePlay/box3.png", "box3.png");
        this.boxInfo = new cc.Sprite("statics/js/res/GamePlay/box1.png");
        this.addChild(this.boxInfo, 1);
        this.boxInfo.setVisible(true);
        this.boxInfo.setPosition(this.manHead1.getPosition());

        var frames = [];
        // 遍历pist中的每张子图, 将子图加入frame中
        for (var i = 1; i <= 3; i++) {

            // 【注意】：这里不用加 #
            var str = "box" + i+ ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(str);
            frames.push(frame);
        }

        // 定义一个【动画】，每隔0.2秒播放一帧
        var animation = new cc.Animation(frames, 0.15);
        // 动画【动作】
        var animate = cc.animate(animation);
        var sequence = cc.sequence(animate, animate.reverse());
        //让精灵frameSprite执行这个动作，循环执行
        this.boxInfo.runAction(sequence.repeatForever());


    },
    loadBegan : function(){
        var node = new cc.Sprite(res.beganGame_png);
        this.addChild(node);
        node.setPosition(this.width / 2, node.height / 2 + 30);

        var listener = cc.EventListener.create({
            event : cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches : true,
            onTouchBegan : function(touch, event){
                var target = event.getCurrentTarget();
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var size = target.getContentSize();
                var rect = cc.rect(0, 0, size.width, size.height);
                if (!(cc.rectContainsPoint(rect, locationInNode))) {
                    return false;
                }

                return true;
            },
            onTouchEnded: function (touch, event) {
                var target = event.getCurrentTarget();

                target.parent.parent.onGameStart(target.parent.selectIndex);
            }
        });
        cc.eventManager.addListener(listener, node);
    }
});

