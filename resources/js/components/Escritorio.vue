<template>
    <main class="app-content">
        <div class="app-title">
          <h1><i class="bi bi-speedometer"></i> Escritorio</h1>
          <p>Aqui vez un resumen de todos los Activos</p>
        </div>
        <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
            <div class="info">
              <h4>Usuarios</h4>
              <p><b>{{ users }}</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon bi bi-archive fs-1" ></i>
            <div class="info">
              <h4>Activos</h4>
              <p><b>{{ activos }}</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon bi bi-person-vcard fs-1"></i>
            <div class="info">
              <h4>Responsables</h4>
              <p><b>{{ responsables }}</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon bi bi-building-check fs-1"></i>
            <div class="info">
              <h4>Oficinas</h4>
              <p><b>{{ oficinas }}</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Activos por Grupo Contable</h3>
            <div class="ratio ratio-16x9 d-flex d-flex justify-content-center align-items-center">
              <Bar
                    id="bar-chart"
                    :options="chartOptions"
                    :data="chartData2"
                  />
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Estado de Activos</h3>
            <div class="ratio ratio-16x9 d-flex d-flex justify-content-center align-items-center">
              <Doughnut
                    id="bar-chart"
                    :options="chartOptions"
                    :data="chartData"
                  />
            </div>
          </div>
        </div>
        
      </div>
    </main>
</template>
<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, ArcElement, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import axios from 'axios';
ChartJS.register(Title, Tooltip, Legend, ArcElement,  BarElement, CategoryScale, LinearScale)
import { Doughnut } from 'vue-chartjs'
import { resolveDirective } from 'vue';

export default {
  name: 'BarChart',
  components: {
    Doughnut,Bar
  },
  data() {
    return {
      users:0,
      activos:0,
      oficinas:0,
      responsables:0,
      etiquetas:[],
      valores:[],
      etiquetas2:[],
      valores2:[],
      chartData: {
        labels: [],
        datasets: [ { data: [] } ]
      },
      chartData2: {
        labels: [],
        datasets: [ { data: [] } ]
      },
      chartOptions: {
        responsive: true,
      }
    }
  },
  
  methods: {
    listar (){
        var url= '/escritorio/';
        axios.get(url).then((response)=> {
          this.users=response.data.users;
          this.activos=response.data.activos;
          this.oficinas=response.data.oficinas;
          this.responsables=response.data.responsables;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
  },
  async mounted() {
    this.listar();
    const totales = await axios.get('http://192.168.28.219/escritorio/grafica1');
    totales.data.estados.map((row)=>{
      this.etiquetas.push(row.nomestado),
      this.valores.push(row.valor)
    });
    this.chartData = {
      labels:this.etiquetas,
      datasets:[
        {label:'Cantidad', data: this.valores,backgroundColor: ['#0dcaf0','#6610f2','#fd7e14']}
    ]
    }
    const auxiliares = await axios.get('http://192.168.28.219/escritorio/grafica2');
    auxiliares.data.gcontable.map((row)=>{
      this.valores2.push(row.nombre),
      this.etiquetas2.push(row.valor)
    });
    this.chartData2 = {
      labels:this.valores2,
      datasets:[
        {label:'Cantidad', data: this.etiquetas2,backgroundColor: ['#A1A2A6','#024959','#F2C335','#0dcaf0','#F2AE30','#6610f2','#fd7e14','#593E25','#034001','#027368']}
    ]
    }
  }
}
</script>