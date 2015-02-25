/**
 * Created by lingjianfeng on 15/2/20.
 */

var GamePlayLayer = cc.LayerColor.extend({
    index : 0,
    chooseHeadLayer : null,
    topPanel        : null,
    head            : null,
    leftFist        : null,
    leftLock        : false,
    rightFist       : null,
    rightLock       : false,
    bar             : null,
    infoPanel       : null,
    delayTime       : 6,
    minDelayTime    : 1.6,
    delayTimeStep   : 0.03,
    currPlace       : -1,        // -1, 0, 1
    arrayStates     : null,
    isInvincibility : false,        //无敌
    hitLabel        : null,
    ctor : function(){
        this._super(cc.color(0, 0, 0, 255));
        this.loadChooseHeadLayer();
        this.loadConfig();
        this.loadPanel();
//        this.onGameStart(0); // TODO 临时
        this.loadBar();
        this.loadHitLabel();
        this.loadFist();
        this.loadButton();
//        this.onGameLoop();
//        this.onEnterInvincibility();
//        this.onGameOver();
    },
    loadChooseHeadLayer : function(){
        this.chooseHeadLayer = new ChooseHeadLayer();
        this.addChild(this.chooseHeadLayer, 9999);
        this.chooseHeadLayer.setPosition(0, GC.h2);
    },
    loadConfig : function(){
        this.arrayStates = new Array();
    },
    onGameStart : function(index){
        this.loadHead(index);
        this.onGameLoop();
        this.removeChooseHeadLayer();
    },
    loadPanel : function(){
        this.topPanel = new cc.LayerColor(cc.color(255, 255, 120, 255), GC.w, GC.h2);
        this.addChild(this.topPanel, 100);
        this.topPanel.setPosition(0, GC.h2);

        var buttomPanel = new cc.LayerColor(cc.color(120, 255, 120, 255), GC.w, GC.h2);
        this.addChild(buttomPanel, 10);

        var tmpNode = new cc.Sprite(res.info_png);
        var buttonLayer = new cc.LayerColor(cc.color(255, 165, 165, 255), GC.w, tmpNode.height * 2);
        this.addChild(buttonLayer, 10);

        this.infoPanel = new cc.LayerColor(cc.color(0, 0, 120, 255), GC.w, tmpNode.height);
        this.addChild(this.infoPanel, 10);
        this.infoPanel.y = GC.h2 - 2 * tmpNode.height - (new cc.Sprite(res.bar_png).height + this.infoPanel.height / 2);

    },
    loadHead : function(index){
        var texture = null;
        switch (index){
            case 0:
                texture = res.manHead1_png;
                break;
            case 1:
                texture = res.manHead2_png;
                break;
            case 2:
                texture = res.woManHead1_png;
                break;
            case 3:
                texture = res.woManHead2_png;
                break;
        }
        this.head = new cc.Sprite(texture);
        this.addChild(this.head, 1000);
        this.head.setPosition(this.head.width / 2, GC.h - this.head.height - 30);

    },
    loadHitLabel : function(){
        this.hitLabel = new cc.LabelTTF("0 hit", "Arial", 30);
        this.addChild(this.hitLabel, 998);
        this.hitLabel.setColor(cc.color(255, 30, 30));
        this.hitLabel.setPosition(GC.w - this.hitLabel.width, GC.h - this.hitLabel.height);
    },
    loadFist : function(){
        this.leftFist = new cc.Sprite(res.fist_png);
        this.addChild(this.leftFist, 1000);
        this.leftFist.setPosition(GC.w2 - this.leftFist.width, GC.h2 + this.leftFist.height);

        this.rightFist = new cc.Sprite(res.fist_png);
        this.addChild(this.rightFist, 1000);
        this.rightFist.setFlippedX(true);
        this.rightFist.setPosition(GC.w2 + this.rightFist.width, GC.h2 + this.rightFist.height);
    },
    loadBar : function(){
        var barBg = new cc.Sprite(res.barBg_png);
        this.addChild(barBg, 110);
        barBg.setScaleX(GC.w / barBg.getContentSize().width);
        barBg.setPosition(GC.w2, GC.h2);

        this.bar = new BarSprite(res.bar_png);
        this.addChild(this.bar, 999);
        this.bar.setPosition(0, GC.h2);
        this.bar.setPercent(0);
    },
    loadButton : function(){

        var leftNormal    = new cc.Sprite(res.left0_png);
        var leftSelected  = new cc.Sprite(res.right0_png);
        var leftDisabled  = new cc.Sprite(res.left0_png);

        var rightNormal    = new cc.Sprite(res.right0_png);
        var rightSelected  = new cc.Sprite(res.left0_png);
        var rightDisabled  = new cc.Sprite(res.right0_png);

        var offsetX = 40;
        var left = new cc.MenuItemSprite(
            leftNormal,
            leftSelected,
            leftDisabled,
            this.onHitHead);
        left.setPosition(GC.w2 - left.getContentSize().width - offsetX, left.getContentSize().height);
        left.tag = 0;
        var right = new cc.MenuItemSprite(
            rightNormal,
            rightSelected,
            rightDisabled,
            this.onHitHead);
        right.setPosition(GC.w2 + right.getContentSize().width + offsetX, right.getContentSize().height);
        right.tag = 1;
        var menu = new cc.Menu(left, right);
        this.addChild(menu, 11);
        menu.setPosition(0, 0);
    },
    onHitHead : function(sender){

        var self = sender.parent.parent;
        var tag = sender.tag;
        var move1 = cc.moveBy(0.15, cc.p(0, 100));

        if (self.leftLock == true && tag == 0){
            return;
        }else if(self.rightLock == true && tag == 1){
            return;
        }
        var hitOffset = 50;
        // 碰撞检测
        var callBack = cc.callFunc(function(sender){
            if (sender.x >= self.head.x - hitOffset && sender.x <= self.head.x + hitOffset){
                GC.hitCount += 1;
                self.hitLabel.setString(GC.hitCount + " hit");


                if (self.bar.percent < 1){
                    self.bar.onIdentity();
                }else{
                    if (self.isInvincibility == false){
                        self.onEnterInvincibility();
                    }
                }
            }else{
                if (self.isInvincibility == false){
                    self.onGameOver();
                }
            }

        }.bind(sender));
        var callBack1 = cc.callFunc(function(sender){
            if (tag == 0){
                self.leftLock = false;
            }else{
                self.rightLock = false;
            }
        }.bind(sender));
        var action = cc.sequence(move1, callBack, move1.reverse(), callBack1);
        // 左边
        if (tag == 0 && self.leftLock == false){
            self.leftLock = true;
            self.leftFist.runAction(action);
        }else if(tag == 1 && self.rightLock == false){
            self.rightLock = true;
            self.rightFist.runAction(action);
        }

    },
    onGameLoop : function(){
        this.createDirInfo();
        var delayTime = cc.delayTime(this.delayTime);
//        var delayTime1 = cc.delayTime(this.delayTime * 3 / 2);
//        var callBack1 = cc.callFunc(function(sender){
//            this.onHeadMove();
//        }.bind(this));
        var callBack2 = cc.callFunc(function(sender){
            this.onGameLoopCopy();
        }.bind(this));

//        var seq = cc.sequence(delayTime1, callBack1);
        var seq2 = cc.sequence(delayTime, callBack2);

//        this.runAction(seq);
        this.runAction(seq2);
        this.delayTime -= this.delayTimeStep;

    },
    onGameLoopCopy : function(sender){
        var delayTime = this.delayTime > this.minDelayTime ? cc.delayTime(this.delayTime) : cc.delayTime(this.minDelayTime);
        var callBack = cc.callFunc(this.onGameLoopCopy.bind(this));

        var seq = cc.sequence(delayTime, callBack);
        this.runAction(seq);

        this.createDirInfo();

        if (this.delayTime >= this.minDelayTime){
            this.delayTime -= this.delayTimeStep;
        }
    },
    createDirInfo : function(){
        var tmpNode = new cc.Sprite(res.info_png);
        var layer = new cc.LayerColor(cc.color(this.index * 45, 255, 0, 255), GC.w, tmpNode.height);
        layer.y = this.infoPanel.height + tmpNode.height;
        this.addChild(layer, 12);
        layer.tag = 111;

        var move = cc.moveTo(this.delayTime * 3, cc.p(0, GC.h2));
        var seq = cc.sequence(move, cc.callFunc(function(){
            this.removeFromParent();
        }.bind(layer)));
        layer.runAction(seq);

        this.arrayStates[this.index] = new Array();
        var bool = false;

        var path = "";
        for (var i = 0; i < 3; i++){

            switch(this.currPlace){
                case 0:
                    var tmp = Math.floor(Math.random() * 2);
                    if (tmp == 0 ){
                        this.currPlace += -1;
                        bool = false;
                        path += "0";
                    }else{
                        this.currPlace += 1;
                        bool = true;
                        path += "1";
                    }
                    break;
                case -1:
                    this.currPlace += 1;
                    bool = true;
                    path += "1";
                    break;
                case 1:
                    path += "0";
                    bool = false;
                    this.currPlace -= 1;
                    break;
            }

            this.arrayStates[this.index].push(bool);
        }

//        this.head.stopAllActions();
        var moveLeft = cc.moveBy(this.delayTime / 3, cc.p(-(GC.w2 - tmpNode.width / 2), 0));
        var moveRight = cc.moveBy(this.delayTime / 3, cc.p((GC.w2 - tmpNode.width / 2), 0));
        switch (path){
            case "001":
                var seq = cc.sequence(moveLeft.clone(), moveLeft.clone(), moveRight.clone());
                this.head.runAction(seq);
                break;
            case "011":
                var seq = cc.sequence(moveLeft.clone(), moveRight.clone(), moveRight.clone());
                this.head.runAction(seq);
                break;
            case "010":
                var seq = cc.sequence(moveLeft.clone(), moveRight.clone(), moveLeft.clone());
                this.head.runAction(seq);
                break;
            case "100":
                var seq = cc.sequence(moveRight.clone(), moveLeft.clone(), moveLeft.clone());
                this.head.runAction(seq);
                break;
            case "101":
                var seq = cc.sequence(moveRight.clone(), moveLeft.clone(), moveRight.clone());
                this.head.runAction(seq);
                break;
            case "110":
                var seq = cc.sequence(moveRight.clone(), moveRight.clone(), moveLeft.clone());
                this.head.runAction(seq);
                break;
            default :
                cc.error("error : ", path);
                break;
        }

        // 创建动作。
        for (var i = 0; i < 3; i++){
            var node = new cc.Sprite(res.info_png);
            layer.addChild(node);
            node.x = (i + 1) * (node.width + 30) - 20;
            node.y = layer.height / 2;
            node.setFlippedX(this.arrayStates[this.index][i]);

        }

        this.index += 1;

    },
    removeChooseHeadLayer : function(){
        this.removeChild(this.chooseHeadLayer);
    },
    onEnterInvincibility : function(){
        this.isInvincibility = true;

        var blink = cc.blink(5, 50);
        var call = cc.callFunc(function(){
            this.onExitInvincibility();
        }.bind(this));
        var seq = cc.sequence(blink, call);
        this.topPanel.runAction(seq);

    },
    onExitInvincibility : function(){
        this.isInvincibility = false;
        this.bar.reset();
    },
    onGameOver : function(){
        var child = this.getChildren();
        for (var i = 0; i < child.length; i++){
            var node = child[i];
            if (node.tag == 111){
                node.stopAllActions();
            }
        }
        this.topPanel.stopAllActions();
        this.head.stopAllActions();
        this.stopAllActions();

        this.gameOverLayer = new GameOverLayer();
        this.addChild(this.gameOverLayer, 9999);
    }
});
var GamePlayScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new GamePlayLayer();
        this.addChild(layer);
    }
});

