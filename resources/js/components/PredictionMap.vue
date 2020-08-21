<template>
    <div class="here-map">
        <div ref="map" v-bind:style="{ width: width, height: height }"></div>
    </div>
</template>

<script>
    export default {
        name: "PredictionMap",
        data() {
            return {
                map: {},
                platform: {},
                ui: {},
                bubble: {}
            }
        },
        props: {
            apikey: String,
            width: String,
            height: String,
            center: Object,
            origin: Object,
            destination: Object,
            waypoints: Array
        },
        created() {
            this.platform = new H.service.Platform({
                'apikey': this.apikey
            });
        },
        /**
         *  Creates de map and some related objects.
         */
        mounted() {
            let defaultLayers = this.platform.createDefaultLayers();
            this.map = new H.Map(
                this.$refs.map,
                defaultLayers.vector.normal.map,
                {
                    zoom: 16,
                    center: this.center
                }
            );
            let group = new H.map.Group();
            this.map.addObject(group);
            new H.mapevents.Behavior(new H.mapevents.MapEvents(this.map));
            this.ui = H.ui.UI.createDefault(this.map, defaultLayers);
            window.addEventListener('resize', () => map.getViewPort().resize());
            this.setRoute()
        },
        methods: {
            setRoute: function () {
                const router = this.platform.getRoutingService(null, 7);
                let routeRequestParams = {}
                routeRequestParams.representation = 'display'
                routeRequestParams.mode = 'fastest;car;traffic:disabled'
                for (let i = 0; i < this.waypoints.length; i++) {
                    let waypointName = 'waypoint' + i
                    routeRequestParams[waypointName] = 'geo!' + this.pointToString(this.waypoints[i])
                }
                router.calculateRoute(
                    routeRequestParams,
                    this.onSuccess,
                    this.onError
                )
            },
            onSuccess: function (result) {
                let route = result.response.route[0]
                this.addRouteShapeToMap(route);
                this.addManueversToMap(route);
            },
            onError: function (error) {
                console.error(error)
            },
            /**
             * Adds route lines from the given route response
             * @param route
             */
            addRouteShapeToMap: function (route) {
                let lineString = new H.geo.LineString(),
                    routeShape = route.shape,
                    polyline;

                routeShape.forEach(function (point) {
                    let parts = point.split(',');
                    lineString.pushLatLngAlt(parts[0], parts[1]);
                });

                let routeOutline = new H.map.Polyline(lineString, {
                    style: {
                        lineWidth: 10,
                        strokeColor: 'rgba(0, 128, 255, 0.7)',
                        lineTailCap: 'arrow-tail',
                        lineHeadCap: 'arrow-head'
                    }
                });

                let routeArrows = new H.map.Polyline(lineString, {
                        style: {
                            lineWidth: 10,
                            fillColor: 'white',
                            strokeColor: 'rgba(255, 255, 255, 1)',
                            lineDash: [0, 2],
                            lineTailCap: 'arrow-tail',
                            lineHeadCap: 'arrow-head'
                        }
                    }
                );

                let routeLine = new H.map.Group();
                routeLine.addObjects([routeOutline, routeArrows]);
                this.map.addObject(routeLine);
            },
            /**
             * Adds waypoint from the given route
             * @param route
             */
            addManueversToMap: function (route) {
                var svgMarkup = '<svg width="18" height="18" ' +
                    'xmlns="http://www.w3.org/2000/svg">' +
                    '<circle cx="8" cy="8" r="8" ' +
                    'fill="#1b468d" stroke="white" stroke-width="1"  />' +
                    '</svg>',
                    dotIcon = new H.map.Icon(svgMarkup, {anchor: {x: 8, y: 8}}),
                    group = new H.map.Group(),
                    i,
                    j;

                for (i = 0; i < route.leg.length; i += 1) {
                    for (j = 0; j < route.leg[i].maneuver.length; j += 1) {
                        let maneuver = route.leg[i].maneuver[j];
                        var marker = new H.map.Marker({
                                lat: maneuver.position.latitude,
                                lng: maneuver.position.longitude
                            },
                            {icon: dotIcon});
                        marker.instruction = maneuver.instruction;
                        group.addObject(marker);
                    }
                }
                let vm = this
                group.addEventListener('tap', function (evt) {
                    vm.map.setCenter(evt.target.getGeometry());
                    vm.openBubble(
                        evt.target.getGeometry(), evt.target.instruction);
                }, false);

                this.map.addObject(group);
            },
            openBubble: function (position, text) {
                if (this.isEmpty(this.bubble)) {
                    this.bubble = new H.ui.InfoBubble(
                        position,
                        {content: text});
                    this.ui.addBubble(this.bubble);
                } else {
                    this.bubble.setPosition(position);
                    this.bubble.setContent(text);
                    this.bubble.open();
                }
            },
            pointToString: function (point) {
                return point.lat + ',' + point.lng
            },
            isEmpty: function (obj) {
                if (obj == null) return true;
                if (_.isArray(obj) || _.isString(obj)) return obj.length === 0;
                for (var key in obj) if (_.has(obj, key)) return false;
                return true;
            }
        }
    }
</script>

<style scoped></style>