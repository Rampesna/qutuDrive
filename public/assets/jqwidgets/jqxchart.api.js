/*
jQWidgets v13.1.0 (2021-Nov)
Copyright (c) 2011-2021 jQWidgets.
License: https://jqwidgets.com/license/
*/
/* eslint-disable */

(function(a){a.extend(a.jqx._jqxChart.prototype,{_moduleApi:true,getItemsCount:function(f,b){var d=this.seriesGroups[f];if(!this._isSerieVisible(f,b)){return 0}var e=this._renderData;if(!d||!e||e.length<=f){return 0}var c=d.series[b];if(!c){return 0}return e[f].offsets[b].length},getXAxisRect:function(c){var b=this._renderData;if(!b||b.length<=c){return undefined}if(!b[c].xAxis){return undefined}return b[c].xAxis.rect},getXAxisLabels:function(k){var d=[];var l=this._renderData;if(!l||l.length<=k){return d}l=l[k].xAxis;if(!l){return d}var j=this.seriesGroups[k];if(j.polar||j.spider){for(var e=0;e<l.polarLabels.length;e++){var h=l.polarLabels[e];d.push({offset:{x:h.x,y:h.y},value:h.value})}return d}var c=this._getXAxis(k);var g=this.getXAxisRect(k);var b=c.position=="top"||c.position=="right";var f=j.orientation=="horizontal";for(var e=0;e<l.data.length;e++){if(f){d.push({offset:{x:g.x+(b?0:g.width),y:g.y+l.data.data[e]},value:l.data.xvalues[e]})}else{d.push({offset:{x:g.x+l.data.data[e],y:g.y+(b?g.height:0)},value:l.data.xvalues[e]})}}return d},getValueAxisRect:function(c){var b=this._renderData;if(!b||b.length<=c){return undefined}if(!b[c].valueAxis){return undefined}return b[c].valueAxis.rect},getValueAxisLabels:function(h){var c=[];var j=this._renderData;if(!j||j.length<=h){return c}j=j[h].valueAxis;if(!j){return c}var k=this._getValueAxis(h);var b=k.position=="top"||k.position=="right";var g=this.seriesGroups[h];var e=g.orientation=="horizontal";if(g.polar||g.spider){for(var d=0;d<j.polarLabels.length;d++){var f=j.polarLabels[d];c.push({offset:{x:f.x,y:f.y},value:f.value})}return c}for(var d=0;d<j.items.length;d++){if(e){c.push({offset:{x:j.itemOffsets[j.items[d]].x+j.itemWidth/2,y:j.rect.y+(b?j.rect.height:0)},value:j.items[d]})}else{c.push({offset:{x:j.rect.x+j.rect.width,y:j.itemOffsets[j.items[d]].y+j.itemWidth/2},value:j.items[d]})}}return c},getPlotAreaRect:function(){return this._plotRect},getRect:function(){return this._rect},showToolTip:function(f,c,e,b,d){var g=this.getItemCoord(f,c,e);if(isNaN(g.x)||isNaN(g.y)){return}this._startTooltipTimer(f,c,e,g.x,g.y,b,d)},hideToolTip:function(c){if(isNaN(c)){c=0}var b=this;b._cancelTooltipTimer();setTimeout(function(){b._hideToolTip(0)},c)},})})(jqxBaseFramework);

