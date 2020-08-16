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
                platform: {}
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
        mounted() {
            console.log("points" + this.waypoints)
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
            /*let marker = new H.map.Marker({lng: this.center_lng, lat: this.center_lat});
            group.addObject(marker);*/
            new H.mapevents.Behavior(new H.mapevents.MapEvents(this.map));
            H.ui.UI.createDefault(this.map, defaultLayers);
            window.addEventListener('resize', () => map.getViewPort().resize());
            this.setRoute()
        },
        methods: {
            setRoute: function () {
                var router = this.platform.getRoutingService(null, 8),
                    routeRequestParams = {
                        routingMode: 'fast',
                        transportMode: 'car',
                        origin: this.pointToString(this.origin),
                        destination: this.pointToString(this.destination),
                        return: 'polyline,turnByTurnActions,actions,instructions,travelSummary'
                    };
                router.calculateRoute(
                    routeRequestParams,
                    this.onSuccess,
                    this.onError
                )
            },
            onSuccess: function (result) {
                var route = result.routes[0];
                this.addRouteShapeToMap(route);
                this.addManueversToMap(route);
            },
            onError: function (error) {

            },
            /**
             * Adds route lines from the given route response
             * @param route
             */
            addRouteShapeToMap: function (route) {
                route.sections.forEach((section) => {
                    let linestring = H.geo.LineString.fromFlexiblePolyline(section.polyline);

                    let polyline = new H.map.Polyline(linestring, {
                        style: {
                            lineWidth: 4,
                            strokeColor: 'rgba(0, 128, 255, 0.7)'
                        }
                    });
                    this.map.addObject(polyline);
                    this.map.getViewModel().setLookAtData({
                        bounds: polyline.getBoundingBox()
                    });
                });
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
                route.sections.forEach((section) => {
                    let poly = H.geo.LineString.fromFlexiblePolyline(section.polyline).getLatLngAltArray();

                    let actions = section.actions;
                    for (i = 0; i < actions.length; i += 1) {
                        let action = actions[i];
                        var marker = new H.map.Marker({
                                lat: poly[action.offset * 3],
                                lng: poly[action.offset * 3 + 1]
                            },
                            {icon: dotIcon});
                        marker.instruction = action.instruction;
                        group.addObject(marker);
                    }

                    this.map.addObject(group);
                });
            },
            pointToString: function (point) {
                return point.lat+','+point.lng
            }
        }
    }
</script>

<style scoped></style>