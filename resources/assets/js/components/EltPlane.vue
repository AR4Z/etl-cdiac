<template>
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group col-md-12">
            <label class="control-label col-md-4">Seleccione la Red</label>
            <select class="form-control col-md-6" v-model="netSelected" v-on:change="loadStation">
                <option selected="selected" disabled="disabled" hidden="hidden" value="null">Seleccione La Red</option>
                <option v-for="netOption in netOptions" v-bind:value="netOption.net_name">
                    {{ netOption.net_name }}
                 </option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label class="control-label col-md-4">Seleccione la Estación</label>
            <select class="form-control col-md-6" v-model="stationSelected" v-on:change="enableFile">
                <option selected="selected" disabled="disabled" hidden="hidden" value="null">Seleccione La Estación</option>
                <option v-for="stationOption in stationOptions" v-bind:value="stationOption.id">
                    {{ stationOption.name }}
                 </option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                netSelected: null,
                netOptions: [],

                stationSelected : null,
                stationOptions : [],
                enableFile: false,
            }
        },
        methods: {
            loadStation(){
                axios.post(`/etl-cdiac/plane-etl/getStationsForNet`,{net_name: this.netSelected})
                    .then(response => {this.stationOptions = response.data;})
            },
        },
        mounted() {
            axios.post(`/etl-cdiac/plane-etl/getDifferentNetName`).then(response => {this.netOptions = response.data;})
        }
    }
</script>
