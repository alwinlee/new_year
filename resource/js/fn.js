function getTimeString(time,type) {
	var date=new Date(time);
	if (type=='minute'||type=='hour') {
		return date.toLocaleTimeString();
	}
	if (type=='day') {
		return date.toLocaleDateString() + " " + date.toLocaleTimeString();
	}
	return date.toLocaleDateString();
};
var vm_chart,vif_chart,vbd_chart;
var showInstancePerf=function(uuid) {
    var time=$('#perf_instance .time .btn.active').attr('timetype');
    var level=$('#perf_instance .level .btn.active').attr('level');
    if (!uuid) {
        uuid=$('#perf_instance').attr('uuid');
        if (!uuid) {
            msgbox('showInstancePerf参数错误-缺uuid','error');
            return;
        }
    } else {
        $('#perf_instance').attr('uuid',uuid);
    }
    if(vm_chart){vm_chart.clear();vm_chart.dispose();vm_chart=null;}
    if(vif_chart){vif_chart.clear();vif_chart.dispose();vif_chart=null;}
    if(vbd_chart){vbd_chart.clear();vbd_chart.dispose();vbd_chart=null;}
    
    fiwo.monitor.getInstancePerf(uuid,'cpu_memory','*',level,time,15,function(data) {
        if (!$.isEmptyObject(data.perf)) {					
            vm_chart=echarts.init($('#perf_instance #cpu_memory').get(0));
            //data.perf.sort(function(a,b){return a.deviceName>b.deviceName?1:-1});//从小到大排序
            $.each(data.perf,function() {
                if (this.deviceType=='cpu') {
                    var _time=getTimeString(this.time,time);
                    cm_option.series[0].data.push((this.value * 100).toFixed(2));
                    cm_option.xAxis[0].data.push(_time);
                } else if (this.deviceType=='memory'&&this.deviceName=='memory_usage') {
                    cm_option.series[1].data.push(this.value.toFixed(2));
                }
            });
            vm_chart.setOption(cm_option);
        }
    });
    
    fiwo.monitor.getInstancePerf(uuid,'vif','*',level,time,60,function(data) {
        if (!$.isEmptyObject(data.perf)) {			
            vif_chart=echarts.init($('#perf_instance #vif').get(0));
            //data.perf.sort(function(a,b){return a.deviceName>b.deviceName?1:-1});//从小到大排序
            $.each(data.perf,function() {
                var _time=getTimeString(this.time,time);
                if (!vif_option.xAxis[0].data.contains(_time)){vif_option.xAxis[0].data.push(_time);}

                var _name=this.deviceName.replace('vif_','eth').replace('_rx',' 流入').replace('_tx',' 流出');
                if (_name=='vif') {_name='总计';}
                if (!vif_option.legend.data.contains(_name)) {
                    vif_option.legend.data.push(_name);
                    vif_option.series.push({
                        name:_name,
                        type:'line',
                        data:[]
                    });
                }
                for ( var i in vif_option.series) {
                    if (vif_option.series[i].name==_name) {
                        vif_option.series[i].data.push((this.value / 1024).toFixed(2));
                        break;
                    }
                }
            });
            vif_chart.setOption(vif_option);
        }
    });
    fiwo.monitor.getInstancePerf(uuid,'vbd','*',level,time,60,function(data) {
        if (!$.isEmptyObject(data.perf)) {			
            vbd_chart=echarts.init($('#perf_instance #vbd').get(0));
            //data.perf.sort(function(a,b){return a.deviceName>b.deviceName?1:-1});//从小到大排序
            $.each(data.perf,function() {
                var _time=getTimeString(this.time,time);
                if (!vbd_option.xAxis[0].data.contains(_time)){vbd_option.xAxis[0].data.push(_time);}
                    
                var _name=this.deviceName.replace('vbd_hd','磁盘').replace('_write',' 写入').replace('_read',' 读出');
                if (_name=='vbd') {_name='总计';}
                if (!vbd_option.legend.data.contains(_name)) {
                    vbd_option.legend.data.push(_name);
                    vbd_option.series.push({
                        name:_name,
                        type:'line',
                        data:[]
                    });
                }
                for ( var i in vbd_option.series) {
                    if (vbd_option.series[i].name==_name) {
                        vbd_option.series[i].data.push((this.value / 1024).toFixed(2));
                        break;
                    }
                }
            });
            vbd_chart.setOption(vbd_option);
        }
    });
    var cm_option={
        title:{
            y:'top',x:'left',
            text:'CPU、内存使用率',
            subtext:'百分比'
        },
        grid:{
            x2:50
        },       
        tooltip:{
            trigger:'axis'
        },
        legend:{
            orient:'horizontal',x:'center',y:'bottom',
            data:[ 'CPU','内存' ]
        },
        toolbox:{
            orient:'horizontal',
            show:true,
            feature:{
                magicType:{
                    show:true,
                    type:[ 'line','bar' ]
                },
                restore:{
                    show:true
                },
                saveAsImage:{
                    show:true
                }
            }
        },
        calculable:true,
        xAxis:[ {
            type:'category',
            boundaryGap:false,
            data:[]
        } ],
        yAxis:[ {
            type:'value',
            axisLabel:{
                formatter:'{value} %'
            }
        } ],
        series:[ {
            name:'CPU',
            type:'line',
            data:[]
        },{
            name:'内存',
            type:'line',
            data:[]
        } ]
    };
    var vif_option={
        title:{
            y:'top',x:'left',
            text:'网卡使用状况',
            subtext:'kb/s'
        },
        grid:{
            x2:50
        },         
        tooltip:{
            trigger:'axis'
        },
        legend:{
            orient:'horizontal',x:'center',y:'bottom',
            data:[]
        },
        toolbox:{
            orient:'horizontal',
            show:true,
            feature:{
                magicType:{
                    show:true,
                    type:[ 'line','bar' ]
                },
                restore:{
                    show:true
                },
                saveAsImage:{
                    show:true
                }
            }
        },
        calculable:true,
        xAxis:[ {
            type:'category',
            boundaryGap:false,
            data:[]
        } ],
        yAxis:[ {
            type:'value',
            axisLabel:{
                formatter:'{value} kb/s'
            }
        } ],
        series:[]
    };
    var vbd_option={
        title:{
            y:'top',x:'left',
            text:'磁盘使用状况',
            subtext:'kb/s'
        },
        grid:{
            x2:50
        },         
        tooltip:{
            trigger:'axis'
        },
        legend:{
            orient:'horizontal',x:'center',y:'bottom',
            data:[]
        },
        toolbox:{
            orient:'horizontal',
            show:true,
            feature:{
                magicType:{
                    show:true,
                    type:[ 'line','bar' ]
                },
                restore:{
                    show:true
                },
                saveAsImage:{
                    show:true
                }
            }
        },
        calculable:true,
        xAxis:[ {
            type:'category',
            boundaryGap:false,
            data:[]
        } ],
        yAxis:[ {
            type:'value',
            axisLabel:{
                formatter:'{value} kb/s'
            }
        } ],
        series:[]
    };
}

var host_chart,host_mem_chart,pif_chart,pbd_chart;
function showHostPerf(uuid) {
    var time=$('#perf_host .time .btn.active').attr('timetype');
    var level=$('#perf_host .level .btn.active').attr('level');
    if (!uuid) {
        uuid=$('#perf_host').attr('uuid');
        if (!uuid) {
            msgbox('showHostPerf参数错误-缺uuid','error');
            return;
        }
    } else {
        $('#perf_host').attr('uuid',uuid);
    }
    if(host_chart){host_chart.clear();host_chart.dispose();host_chart=null;}
    if(host_mem_chart){host_mem_chart.clear();host_mem_chart.dispose();host_mem_chart=null;}
    if(pif_chart){pif_chart.clear();pif_chart.dispose();pif_chart=null;}
    if(pbd_chart){pbd_chart.clear();pbd_chart.dispose();pbd_chart=null;}
    
    fiwo.monitor.getHostPerf(uuid,'cpu','*',level,time,15,function(data) {
        if (!$.isEmptyObject(data.perf)) {
            host_chart=echarts.init($('#perf_host #cpu').get(0));
            $.each(data.perf,function() {
                if (this.deviceType=='cpu') {
                    var _time=getTimeString(this.time,time);
                    cm_option.series[0].data.push((this.value * 100).toFixed(2));
                    cm_option.xAxis[0].data.push(_time);
                } else if (this.deviceType=='memory'&& this.deviceName=='memory_usage') {
                    cm_option.series[1].data.push(this.value.toFixed(2));
                }
            });
            host_chart.setOption(cm_option);
        }
    });
    fiwo.monitor.getHostPerf(uuid,'memory','*',level,time,15,function(data) {
        if (!$.isEmptyObject(data.perf)) {
            host_mem_chart=echarts.init($('#perf_host #memory').get(0));
            $.each(data.perf,function() {
                if (this.deviceName=='memory_total_kib') {
                    var _time=getTimeString(this.time,time);
                    mem_option.series[0].data.push((this.value / 1024).toFixed(1));
                    mem_option.xAxis[0].data.push(_time);
                } else if ( this.deviceName=='memory_free_kib') {
                    mem_option.series[1].data.push((this.value / 1024).toFixed(1));
                } else if ( this.deviceName=='memory_available') {
                    mem_option.series[2].data.push((this.value / 1024).toFixed(1));
                    }
            });
            host_mem_chart.setOption(mem_option);
        }
    });
    fiwo.monitor.getHostPerf(uuid,'pif','*',level,time,60,function(data) {
        if (!$.isEmptyObject(data.perf)) {
            pif_chart=echarts.init($('#perf_host #pif').get(0));
            //data.perf.sort(function(a,b){return a.deviceName>b.deviceName?1:-1});//从小到大排序
            $.each(data.perf,function() {
                var _time=getTimeString(this.time,time);
                if (!pif_option.xAxis[0].data.contains(_time)){pif_option.xAxis[0].data.push(_time);}                    

                var _name=this.deviceName.replace('pif_eth','eth').replace('pif_lo','loopback')
                .replace('pif_aggr','总计').replace('_rx',' 流入').replace('_tx',' 流出');
                if (!pif_option.legend.data.contains(_name)) {
                    pif_option.legend.data.push(_name);
                    pif_option.series.push({
                        name:_name,
                        type:'line',
                        data:[]
                    });
                }
                for ( var i in pif_option.series) {
                    if (pif_option.series[i].name==_name) {
                        pif_option.series[i].data.push((this.value / 1024).toFixed(2));
                        break;
                    }
                }
            });
            pif_chart.setOption(pif_option);
        }
    });
    fiwo.monitor.getHostPerf(uuid,'io','*',level,time,60,function(data) {
        if (!$.isEmptyObject(data.perf)) {
            pbd_chart=echarts.init($('#perf_host #pbd').get(0));
            $.each(data.perf,function() {
                var _time=getTimeString(this.time,time);
                if (!pbd_option.xAxis[0].data.contains(_time)){pbd_option.xAxis[0].data.push(_time);}
                    
                var _name=this.deviceName.replace('pbd_hd','磁盘').replace('_write',' 写入').replace('_read',' 读出');
                if (_name=='pbd') {_name='总计';}
                if (!pbd_option.legend.data.contains(_name)) {
                    pbd_option.legend.data.push(_name);
                    pbd_option.series.push({
                        name:_name,
                        type:'line',
                        data:[]
                    });
                }
                for ( var i in pbd_option.series) {
                    if (pbd_option.series[i].name==_name) {
                        pbd_option.series[i].data.push((this.value/1024).toFixed(2));
                        break;
                    }
                }
            });
            pbd_chart.setOption(pbd_option);
        }
    });
    var cm_option={
        title:{
            y:'top',x:'left',
            text:'CPU',
            subtext:'百分比'
        },
        grid:{
            x2:50
        },         
        tooltip:{
            trigger:'axis'
        },
        legend:{
            orient:'horizontal',x:'center',y:'bottom',
            data:[ 'CPU' ]
        },
        toolbox:{
            orient:'horizontal',
            show:true,
            feature:{
                magicType:{
                    show:true,
                    type:[ 'line','bar' ]
                },
                restore:{
                    show:true
                },
                saveAsImage:{
                    show:true
                }
            }
        },
        calculable:true,
        xAxis:[ {
            type:'category',
            boundaryGap:false,
            data:[]
        } ],
        yAxis:[ {
            type:'value',
            axisLabel:{
                formatter:'{value} %'
            }
        } ],
        series:[ {
            name:'CPU',
            type:'line',
            data:[]
        } ]
    };
    var mem_option={
            title:{
                y:'top',x:'left',
                text:'内存使用状况',
                subtext:'MB'
            },
            grid:{
                x2:50
            },             
            tooltip:{
                trigger:'axis'
            },
            legend:{
                orient:'horizontal',x:'center',y:'bottom',
                data:[ '总量','空余','可用' ]
            },
            toolbox:{
                orient:'horizontal',
                show:true,
                feature:{
                    magicType:{
                        show:true,
                        type:[ 'line','bar' ]
                    },
                    restore:{
                        show:true
                    },
                    saveAsImage:{
                        show:true
                    }
                }
            },
            calculable:true,
            xAxis:[ {
                type:'category',
                boundaryGap:false,
                data:[]
            } ],
            yAxis:[ {
                type:'value',
                axisLabel:{
                    formatter:'{value} MB'
                }
            } ],
            series:[ {
                name:'总量',
                type:'line',
                data:[]
            },{
                name:'空余',
                type:'line',
                data:[]
            },{
                name:'可用',
                type:'line',
                data:[]
            } ]
        };
    var pif_option={
        title:{
            y:'top',x:'left',
            text:'网卡使用状况',
            subtext:'kb/s'
        },
        grid:{
            x2:50
        },         
        tooltip:{
            trigger:'axis'
        },
        legend:{
            orient:'horizontal',x:'center',y:'bottom',
            data:[]
        },
        toolbox:{
            orient:'horizontal',
            show:true,
            feature:{
                magicType:{
                    show:true,
                    type:[ 'line','bar' ]
                },
                restore:{
                    show:true
                },
                saveAsImage:{
                    show:true
                }
            }
        },
        calculable:true,
        xAxis:[ {
            type:'category',
            boundaryGap:false,
            data:[]
        } ],
        yAxis:[ {
            type:'value',
            axisLabel:{
                formatter:'{value} kb/s'
            }
        } ],
        series:[]
    };
    var pbd_option={
        title:{
            y:'top',x:'left',
            text:'磁盘使用状况',
            subtext:'kb/s'
        },
        grid:{
            x2:50
        },         
        tooltip:{
            trigger:'axis'
        },
        legend:{
            orient:'horizontal',x:'center',y:'bottom',
            data:[]
        },
        toolbox:{
            orient:'horizontal',
            show:true,
            feature:{
                magicType:{
                    show:true,
                    type:[ 'line','bar' ]
                },
                restore:{
                    show:true
                },
                saveAsImage:{
                    show:true
                }
            }
        },
        calculable:true,
        xAxis:[ {
            type:'category',
            boundaryGap:false,
            data:[]
        } ],
        yAxis:[ {
            type:'value',
            axisLabel:{
                formatter:'{value} Kb/s'
            }
        } ],
        series:[]
    };
}

