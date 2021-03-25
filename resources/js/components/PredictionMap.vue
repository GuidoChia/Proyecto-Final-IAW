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
            }
        },
        props: {
            width: String,
            height: String,
            center: Object,
            waypoints: Array
        },
        created() {

        },
        /**
         *  Creates de map and some related objects.
         */
        mounted() {
            this.map = L.map(this.$refs.map).setView(this.center, 15);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);

            this.setRoute()
        },
        methods: {
            setRoute: function () {
                let control = L.Routing.control({
                    waypoints: this.waypoints,
                    collapsible: true,
                    createMarker: function (i, waypoint, n) {
                        return L.marker(waypoint.latLng)
                    }
                })
                control.addTo(this.map)
                control.hide()
            }
        }
    }
</script>

<style scoped></style>