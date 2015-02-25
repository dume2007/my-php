/* 
* @Author: 卓文理 www.zwlme.com
* @Email:  531840344@qq.com
* @Date:   2015-02-12 23:14:10
* @Last Modified by:   卓文理 www.zwlme.com
* @Last Modified time: 2015-02-20 20:36:00
*/


// createCard
// 
// 创建刮刮卡
//
// 基于原生javasc
// 必须使用Element对象
// 参数可以为 具体路径 或者 DataURIs 

Element.prototype.createCard = function(imgURL) {
	var canvas = this,
		img    = new Image();

	img.addEventListener('load',function(){
		var w = img.width,
            h = img.height,
        	offsetX = canvas.offsetLeft,
            offsetY = canvas.offsetTop,
            width   = document.body.clientWidth,
        	mousedown = false,
        	i = 0,
        	ctx;

        function layer(ctx, lw, lh) {
            ctx.fillStyle = 'gray';
            ctx.fillRect(0, 0, lw, lh);
        }

        function eventDown(e){
            e.preventDefault();
            mousedown=true;
        }

        function eventUp(e){
            e.preventDefault();
            mousedown=false;
        }

        function eventMove(e){
            e.preventDefault();
            if(mousedown) {
                if(e.changedTouches){
                    e=e.changedTouches[e.changedTouches.length-1];
                    i++;
                }
                var x = (e.clientX + document.body.scrollLeft || e.pageX) - offsetX || 0,
                    y = (e.clientY + document.body.scrollTop || e.pageY) - offsetY || 0;
                with(ctx) {
                    beginPath()
                    arc(x, y, 10, 0, Math.PI * 2);
                    fill();
                }
		        if (i >= 120) {
                    canvas.style.background = 'url('+img.src+') center center no-repeat';
                    canvas.style.backgroundSize = 'cover';
                    if (!isOpen) {
                        openPop();
                    };
		        };
            }
        }

        ctx = canvas.getContext('2d');
        ctx.fillStyle='transparent';

        if (width >= 640) {
            canvas.width = w * 2;
            canvas.height = h * 2;
            ctx.fillRect(0, 0, w * 2, h * 2);
            layer(ctx, w * 2, h * 2);
        }else if(width >= 480) {
            canvas.width = w * 1.5;
            canvas.height = h * 1.5;
            ctx.fillRect(0, 0, w * 1.5, h * 1.5);
            layer(ctx, w * 1.5, h * 1.5);
        }else{
            canvas.width = w;
            canvas.height = h;
            ctx.fillRect(0, 0, w, h);
            layer(ctx, w, h);
        }

        ctx.globalCompositeOperation = 'destination-out';

        canvas.addEventListener('touchstart', eventDown);
        canvas.addEventListener('touchend', eventUp);
        canvas.addEventListener('touchmove', eventMove);
        canvas.addEventListener('mousedown', eventDown);
        canvas.addEventListener('mouseup', eventUp);
        canvas.addEventListener('mousemove', eventMove);
	});
	
	img.src = imgURL;
};