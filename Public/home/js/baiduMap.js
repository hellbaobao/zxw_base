/**
 * Created by zhangzhihui on 2018/4/24.
 */
// 百度地图API功能

function baiduMap(mapId) {
    var map = new BMap.Map("allmap");
    
    console.log(mapId);

    if(mapId != '') {
        mapIdArray = mapId.split(",");
        var point = new BMap.Point(mapIdArray[0],mapIdArray[1]);
    } else {
        //默认通州区经纬度
        var point = new BMap.Point(116.6684451933,39.8837054556);
    }
    map.centerAndZoom(point, 12);

    var geoc = new BMap.Geocoder();

    var marker = new BMap.Marker(point);  // 创建标注
    map.addOverlay(marker);               // 将标注添加到地图中
    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画

    //提升框
    var opts = {
        width : 200,     // 信息窗口宽度
        height: 100,     // 信息窗口高度
        title : "标题" , // 信息窗口标题
        enableMessage:true,//设置允许信息窗发送短息
        message:"请选择地址吧"
    }

    // 百度地图API功能
    map.centerAndZoom(point,8);
    setTimeout(function(){
        map.setZoom(14);
    }, 500);  //2秒后放大到14级
    map.enableScrollWheelZoom(true);
}

