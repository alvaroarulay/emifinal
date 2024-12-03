export default {
    data (){
        return {
            arrayUnidad:[],
            unidad:'',
            idunidad:'',
            idrol:0,
            titulo:''
        }
    },
    methods: {
        listarUnidad (){
            let me=this;
            var url= '/unidad/select';
            axios.get(url).then( (response) =>{
                var respuesta= response.data;
                me.arrayUnidad = respuesta.unidad;
                me.unidad = respuesta.descripcion;
                me.idunidad = respuesta.idunidad;
                me.idrol = respuesta.idrol;
                me.titulo = respuesta.titulo;
            })
            .catch( (error)=> {
                console.log(error);
            });
        },
    },
    mounted() {
      this.listarUnidad();
    }
  };