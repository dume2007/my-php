/**
 * Created by lingjianfeng on 15/2/20.
 */

var BarSprite = cc.Sprite.extend({
    percent : 0,
    identityUnit : 0.5,
    ctor : function(fileName, rect, rotated){
        this._super(fileName, rect, rotated);

//        this.loadConfig(cc.size(640, 960));
        this.loadInit();
//        this.setPercent(0.7);
    },
    loadInit : function(){
        this.setAnchorPoint(0, 0.5);
    },
    setPercent : function(percent){
        this.setTextureRect(cc.rect(0, 0, GC.w * percent, this.height));
    },
    onIdentity : function(){
        if (this.percent < 1){
            this.percent += this.identityUnit;
            this.setPercent(this.percent);
        }
    },
    reset : function(){
        this.percent = 0;
        this.setPercent(0);
    }
});