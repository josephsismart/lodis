<script>
  // $("#clickMe").attr("data-slide","true");
  $(".clickMe").trigger("click");
  // $(".btn-info").trigger("click");
  $('.select2').select2({
      //placeholder: "SEARCH BARANGAY",
  });

  $(".clickMe").click(function(){
    if($(".clickMe .fas").hasClass("fa-chevron-right")){
      $(".clickMe .fas").removeClass("fa-chevron-right").addClass("fa-chevron-left")
    }else{
      $(".clickMe .fas").removeClass("fa-chevron-left").addClass("fa-chevron-right")
    }
  })

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  });

  if (!window.app) window.app = {};
  var app = window.app;
  app.Popup = function(b) {
      this.autoPan = void 0 !== b.autoPan ? b.autoPan : !1;
      this.margin = void 0 !== b.margin ? b.margin : 10;
      ol.Overlay.call(this, b);
      var c = this;
      !0 === b.closeBox && $('<a href="#" id="popup-closer" class="ol-popup-closer"></a>').click(this.getElement(), function(a) {
          $(c).trigger("close");
          a.data.style.display = "none";
          a.target.blur();
          return !1
      }).appendTo($(this.getElement()));
      $('<div id="popup-content"></div>').appendTo($(this.getElement()))
  };
  ol.inherits(app.Popup, ol.Overlay);
  app.Popup.prototype.setContent = function(b) {
      $("#popup-content").html(b);
  };
  app.Popup.prototype.show = function() {
      $(this.getElement()).show()
  };
  app.Popup.prototype.hide = function() {
      $(this.getElement()).hide()
  };
  app.Popup.prototype.setPosition = function(b) {
      ol.Overlay.prototype.setPosition.call(this, b);
      if (!0 === this.autoPan) {
          var c = this.getMap(),
              a = this.getElement(),
              e = this.margin;
          window.setTimeout(function() {
              var b = c.getView().getResolution(),
                  f = c.getView().getCenter(),
                  g = $(a).offset(),
                  k = $(c.getTarget()).offset(),
                  m = g.top - k.top,
                  l = c.getSize(),
                  g = k.left + l[0] - (g.left + $(a).outerWidth(!0));
              if (0 > m || 0 > g) l = k = 0, 0 > g && (k = (e - g) * b), 0 > m && (l = (e - m) * b), c.getView().setCenter([f[0] + k, f[1] + l])
          }, 0)
      }
  };
  if (!window.app) window.app = {};
  app = window.app;
  app.LayersControl = function(b) {
      this.defaultGroup = "default";
      var b = b || {},
          c = document.createElement("div");
      c.className = "layers-control ol-unselectable";
      b.groups ? (this.groups = b.groups, this.groups[this.defaultGroup] || (this.groups[this.defaultGroup] = {})) : (this.groups = {}, this.groups[this.defaultGroup] = {});
      this.containers = {};
      for (var a in this.groups) this.containers[a] = document.createElement("ul"), this.groups[a].title && $(this.containers[a]).html(this.groups[a].title), c.appendChild(this.containers[a]);
      ol.control.Control.call(this, {
          element: c,
          target: b.target
      })
  };
  ol.inherits(app.LayersControl, ol.control.Control);
  app.LayersControl.prototype.setMap = function() {};
  var url = "<?= $my_url; ?>",
      featurePrefix = "BXUCOVID19TRACKER_WS",
      featureType = "BUTUAN_CITY_MAP",
      featureNS = "http://butuan.gov.ph/bxucovid19tracker/",
      srsName = "EPSG:32651",
      geometryName = "geom",
      geometryType = "MultiPolygon",
      //fields = ["cbrgyname", "clandpin"],
      layerTitle = "BXUCovid19 Parcels",
      infoFormat = "text/html",
      center = [-2.6095594758211E7, 994099],
      zoom = getScreenZoom(),
      bpointXY = [779374.999, 990011.999],
      //Xg_cVa_zCtTC8AeC2YzQDw = ipQ,
      i = 0,
      tab = 0,
      x = 0,
      useradmin = 0,
      pins = [],
      erosion = [],
      soil = [],
      gal = [],
      uid = [],
      xcenter = ol.proj.transform([125.5806, 8.8855], "EPSG:4326", "EPSG:3857"),
      covid_highlight = "BUTUAN_CITY_HIGHLIGHT",
      PUM = "COVID19_PUM",
      CLEARED = "COVID19_CLEARED",
      SUSPECTED = "COVID19_SUSPECTED",
      PROBABLE = "COVID19_PROBABLE",
      CONFIRMED = "COVID19_CONFIRMED2",
      RECOVERED = "COVID19_RECOVERED",
      DEAD = "COVID19_DEAD",
      //TPS_MAP = "TPS_MAP",
      //REC_MAP = "REC_MAP",
      //DED_MAP = "DED_MAP",
      //PUI_MAP = "PUI_MAP",
      //PUM_MAP = "PUM_MAP",
      BUTUAN_LABEL = "BUTUAN_BARANGAY_LABEL";
  var format = new ol.format.GML({
          featureNS: featureNS,
          featureType: featureType
      }),
      popup = new app.Popup({
          element: document.getElementById("popup"),
          closeBox: !1,
          autoPan: !1
      }),
      wmsSource = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + featureType,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourceBUTUAN_LABEL = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + BUTUAN_LABEL,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourceCOVIDBXU = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + covid_highlight,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourcePUM = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + PUM,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourceCLEARED = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + CLEARED,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourceSUSPECTED = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + SUSPECTED,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourcePROBABLE = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + PROBABLE,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourceCONFIRMED = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + CONFIRMED,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourceRECOVERED = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + RECOVERED,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      wmsSourceDEAD = new ol.source.TileWMS({
          url: url,
          params: {
              LAYERS: featurePrefix + ":" + DEAD,
              TILED: !1
          },
          serverType: "geoserver"
      }),
      
      highlight = new ol.layer.Vector({
          style: new ol.style.Style({
              stroke: new ol.style.Stroke({
                  color: "#000000",
                  width: 3
              })
          }),
          source: new ol.source.Vector
      });
  $(popup).on("close", function() {
      highlight.getSource().clear()
  });
  var map = new ol.Map({
      controls: ol.control.defaults().extend([new app.LayersControl({
          groups: {
              background: {
                  title: "Base Layers",
                  exclusive: !0
              },
              "default": {
                  title: "Overlays"
              }
          }
      })]),
      overlays: [popup],
      target: document.getElementById("map"),
      renderer: "canvas",
      layers: [new ol.layer.Tile({
              title: "Street Map",
              group: "background",
              source: new ol.source.OSM({
                  layer: "osm"
              })
          }), new ol.layer.Tile({
              title: "Aerial Imagery",
              group: "background",
              visible: !1,
              source: new ol.source.MapQuest({
                  layer: "sat"
              })
          }), new ol.layer.Group({
              title: "Imagery with Streets",
              group: "background",
              visible: !1,
              layers: [new ol.layer.Tile({
                  source: new ol.source.MapQuest({
                      layer: "sat"
                  })
              }), new ol.layer.Tile({
                  source: new ol.source.MapQuest({
                      layer: "hyb"
                  })
              })]
          }), new ol.layer.Tile({
              title: layerTitle,
              source: wmsSource,
              name: "BUTUAN MAP"
          }),new ol.layer.Tile({
              title: "COVID PUM",
              source: wmsSourcePUM,
              // visible: !1,
              name: "COVID PUM"
          }),new ol.layer.Tile({
              title: "COVID CLEARED",
              source: wmsSourceCLEARED,
              // visible: !1,
              name: "COVID CLEARED"
          }),new ol.layer.Tile({
              title: "COVID SUSPECTED",
              source: wmsSourceSUSPECTED,
              // visible: !1,
              name: "COVID SUSPECTED"
          }),new ol.layer.Tile({
              title: "COVID PROBABLE",
              source: wmsSourcePROBABLE,
              // visible: !1,
              name: "COVID PROBABLE"
          }),new ol.layer.Tile({
              title: "COVID CONFIRMED",
              source: wmsSourceCONFIRMED,
              // visible: !1,
              name: "COVID CONFIRMED"
          }),new ol.layer.Tile({
              title: "COVID RECOVERED",
              source: wmsSourceRECOVERED,
              // visible: !1,
              name: "COVID RECOVERED"
          }),new ol.layer.Tile({
              title: "COVID DEAD",
              source: wmsSourceDEAD,
              // visible: !1,
              name: "COVID DEAD"
          }),new ol.layer.Tile({
              title: "COVID Butuan Map Highlight",
              source: wmsSourceCOVIDBXU,
              visible: !1,
              name: "COVID Butuan Map Highlight"
          }),new ol.layer.Tile({
              title: "BARANGAY LABEL",
              source: wmsSourceBUTUAN_LABEL,
              // visible: !0,
              name: "BARANGAY LABEL"
          })
          ,highlight
      ],
      view: new ol.View({
          center: xcenter,
          zoom: getScreenZoom(),
          projection: "EPSG:3857"
      })
  });

  function zoomMap() {
    var area = $(".searchBarangay option:selected").data('text_area');
    var lat = $(".searchBarangay option:selected").data('text_lat');
    var lon = $(".searchBarangay option:selected").data('text_lon');
    var e = parseFloat(lat),
        a = parseFloat(lon),
        e = [e, a];

    var tpoint = 'POINT(' + e[0] + ' ' + e[1] + ')';
    var coords = ol.proj.transform(e, "EPSG:4326", "EPSG:3857");
    var aq = Math.trunc(area),
        ar = aq.toString().length;
    if(ar>=8){tzoom=12}
    if(ar==7){tzoom=13}
    if(ar==6){tzoom=14}
    if(ar==5){tzoom=16}
    bubble(tpoint,coords);

    b = ol.animation.zoom({
        // source: map.getView().getCenter()
        resolution: map.getView().getResolution()
    });
    map.beforeRender(b);
    map.getView().setCenter(ol.proj.transform(e,
        "EPSG:4326", "EPSG:3857"));
    map.getView().setResolution(map.getView().getResolution() * 2);
    map.getView().setZoom(tzoom);
  }

  function zoomCenter(){
    b = ol.animation.zoom({
        resolution: map.getView().getResolution()
    });
    map.beforeRender(b);
    map.getView().setCenter(xcenter);
    map.getView().setResolution(map.getView().getResolution() * 2);
    map.getView().setZoom(zoom);
  }

  function showLayer(a,b) {
    if(a){
      b.setVisible(!0);
    }else{
      b.setVisible(!1);
    }
  }

  map.on("singleclick", function(b) {
      var coords = ol.proj.transform(b.coordinate, "EPSG:3857", "EPSG:4326");
      var tpoint = 'POINT(' + coords[0] + ' ' + coords[1] + ')';
      var x = 'POINT(' + coords[0] + ', ' + coords[1] + ')';
      bubble(tpoint,b.coordinate);
  });

  function returnDash(a){
    if(a==0){return '-'}
    if(a!=0){return a}
  }

  function getScreenZoom(){
    var width = $(window).width(); 
    var height = $(window).height();

    if ((width>=1024  ) && (height>=768)) {
      return 11.5;
    }else if ((width>682 && width<1024  ) && (height>723 && height<768)) {
      return 11.4;
    }else{
      // setTimeout(function(){
      //   $(".clickMe").trigger("click");
      // },3000)
      return 11;
    }
  }

  function bubble(tpoint,b){
    $.post("<?= base_url() ?>" + "userpublicmap/map/getMap",
        {point:tpoint},
        function(a){
          var result = JSON.parse(a);
          if(result["id"]){
                c = "<div class='row'><div class='col-xs-12 col-lg-12 col-sm-12'>"+
                                "<table class='table-responsive table-bordered table-condensed table-hover' style='white-space:nowrap;font-size:15px;'>"+
                                  "<tr><td><h5 style='margin:0px;'><b>"+result["barangay"]+"</b></h5></td><td width='10' align='center'><a class='leaflet-popup-close-button pull-right' href='#' onclick='popup.hide();' style='color:red;font-size:20px;'>×</a></td></tr>"+

                                  (result["pum"]==0?"":"<tr><td style='color:#17a2b8'><b>PUM</b></td><td align='right'><r2>"+result["pum"]+"</r2></td></tr>")+
                                  (result["clr"]==0?"":"<tr><td style='color:#ffc107'><b>CLEARED</b></td><td align='right'><r2>"+result["clr"]+"</r2></td></tr>")+
                                  (result["sus"]==0?"":"<tr><td style='color:#007bff'><b>SUSPECTED</b></td><td align='right'><r2>"+result["sus"]+"</r2></td></tr>")+
                                  (result["pro"]==0?"":"<tr><td style='color:#6f42c1'><b>PROBABLE</b></td><td align='right'><r2>"+result["pro"]+"</r2></td></tr>")+
                                  (result["tps"]==0?"":"<tr><td style='color:#fd7e14'><b>CONFIRMED</b></td><td align='right'><r2>"+result["tps"]+"</r2></td></tr>")+
                                  (result["rec"]==0?"":"<tr><td style='color:#20c997'><b>RECOVERED</b></td><td align='right'><r2>"+result["rec"]+"</r2></td></tr>")+
                                  (result["ded"]==0?"":"<tr><td style='color:#dc3545'><b>DEAD</b></td><td align='right'><r2>"+result["ded"]+"</r2></td></tr>")+

                                  "</div></div>";
                popup.setPosition(b);
                popup.setContent(c);
                popup.show();
                a = "party_id=="+result["id"];
                b = "party_id";
                d = wmsSourceCOVIDBXU.getParams();
                d.cql_filter = a;
                wmsSourceCOVIDBXU.updateParams(d);
                wmsSourceCOVIDBXU.dispatchEvent("change");
                covidHighlight.setVisible(!0);
            }
          }
    );
  }

  function getMap(b, c) {
      var a = wmsSource.getParams();
      delete a.cql_filter;
      wmsSource.updateParams(a);
      wmsSource.dispatchEvent("change");
      a = wmsSourceHighlightMap.getParams();
      delete a.cql_filter;
      wmsSourceHighlightMap.updateParams(a);
      wmsSourceHighlightMap.dispatchEvent("change");
      a = wmsSourceHighlightMap.getParams();
      a.cql_filter = b;
      wmsSourceHighlightMap.updateParams(a);
      wmsSourceHighlightMap.dispatchEvent("change");
      bmaph.setVisible(!0);
      a = wmsSource.getParams();
      a.cql_filter = c;
      wmsSource.updateParams(a);
      wmsSource.dispatchEvent("change");
      mlayer3.setVisible(!0)
  }

  for (var mlayers = map.getLayers().getArray(), mm = 0; mm < map.getLayers().getArray().length; mm++) {
      if ("COVID Butuan Map Highlight" == mlayers[mm].get("name")) var covidHighlight = mlayers[mm];
      if ("COVID CONFIRMED" == mlayers[mm].get("name")) var covidTPS = mlayers[mm];
      if ("COVID DEAD" == mlayers[mm].get("name")) var covidDED = mlayers[mm];
      if ("COVID SUSPECTED" == mlayers[mm].get("name")) var covidSUS = mlayers[mm];
      if ("COVID PROBABLE" == mlayers[mm].get("name")) var covidPRO = mlayers[mm];
      if ("COVID CLEARED" == mlayers[mm].get("name")) var covidCLEARED = mlayers[mm];
      if ("COVID PUM" == mlayers[mm].get("name")) var covidPUM = mlayers[mm];
      if ("BARANGAY LABEL" == mlayers[mm].get("name")) var barangayLabel = mlayers[mm];
      if ("COVID RECOVERED" == mlayers[mm].get("name")) var covidREC = mlayers[mm];
  }
</script>