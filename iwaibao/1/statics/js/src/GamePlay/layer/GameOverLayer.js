/**
 * Created by lingjianfeng on 15/2/21.
 */



var GameOverLayer = cc.LayerColor.extend({
    ctor : function(){
        this._super(cc.color(0, 255, 255, 0), GC.w, GC.h);
        this.loadConfig;
        this.loadInit();
        this.loadLisenter();
        this.loadButton();
        this.loadText();
        this.loadInfo();
    },
    loadConfig : function(){
    },
    loadInit : function(){
        this.panel = new cc.Sprite();
        this.addChild(this.panel);
        this.panel.setTextureRect(cc.rect(0, 0, GC.w * 0.7, GC.h * 0.6));
        this.panel.setPosition(GC.w2, GC.h2);
        this.panel.setColor(cc.color(200, 0, 0));
    },
    loadLisenter : function(){
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
            }
        });
        cc.eventManager.addListener(listener, this);
    },
    loadButton : function(){
        var self = this;
        var offsetX = 10;
        var y = 60;
        var resartNormal    = new cc.Sprite(res.restart_png);
        var resartSelected  = new cc.Sprite(res.restart_png);
        var resartDisabled  = new cc.Sprite(res.restart_png);

        var shareNormal    = new cc.Sprite(res.share_png);
        var shareSelected  = new cc.Sprite(res.share_png);
        var shareDisabled  = new cc.Sprite(res.share_png);

        var resart = new cc.MenuItemSprite(
            resartNormal,
            resartSelected,
            resartDisabled,
            function(sender){
                cc.log("游戏重启");
                var scene = new cc.Scene();
                var layer = new GamePlayLayer();
                scene.addChild(layer);
                cc.director.runScene(scene);
            }.bind(this));
        resart.setPosition(resartNormal.width / 2 + offsetX, y);
        var share = new cc.MenuItemSprite(
            shareNormal,
            shareSelected,
            shareDisabled,
            function(sender){
                cc.log("[文理][TODO] : 分享");
            }.bind(this));
        share.setPosition(this.panel.width - shareNormal.width / 2 - offsetX, y);


        var rewardNormal    = new cc.Sprite(res.reward_png);
        var rewardSelected  = new cc.Sprite(res.reward_png);
        var rewardDisabled  = new cc.Sprite(res.reward_png);
        var reward = new cc.MenuItemSprite(
            rewardNormal,
            rewardSelected,
            rewardDisabled,
            function(sender){
                cc.log("[文理][TODO] ： 抽奖");
            }.bind(this));
        reward.setPosition(reward.width / 2 + offsetX, resart.y + rewardNormal.height + offsetX);



        var menu = new cc.Menu(resart, share, reward);
        this.panel.addChild(menu);
        menu.setPosition(0, 0);
    },
    loadText : function(){
        var tmpName = "帅哥1号";
        var label = new cc.LabelTTF("酷毙了！" + tmpName + "!", "Arial", 50);
        this.panel.addChild(label);
        label.setPosition(this.panel.width / 2, this.panel.height / 2 + 100 );
        label.setColor(cc.color.BLACK);

        var label1 = new cc.LabelTTF("超越了全国" + GC.hitCount + "%的玩家", "Arial", 35);
        this.panel.addChild(label1);
        label1.setPosition(this.panel.width / 2, this.panel.height / 2 + 50 );
        label1.setColor(cc.color.BLACK);

        var label2 = new cc.LabelTTF("向好友", "Arial", 60);
        this.panel.addChild(label2);
        label2.setPosition(this.panel.width / 2 - 50, this.panel.height / 2 - 20 );
        label2.setColor(cc.color.BLACK);

    },
    loadInfo : function(){
        var offset = 20;
        var info = new cc.Sprite(res.logo_png);
        this.panel.addChild(info)
        info.setPosition(this.panel.width - info.width / 2 - offset, this.panel.height - info.height / 2 - offset);

        var defiance = new cc.Sprite(res.defiance_png);
        this.panel.addChild(defiance);
        defiance.setPosition(this.panel.width - defiance.width / 2, 250);
    }

});


