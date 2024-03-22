document.addEventListener('DOMContentLoaded', function () {
    var htmlElement = document.getElementById('htmlLang');
    var idiomaActual = htmlElement.lang;

    // Definir traducciones
    
    var traducciones = {
        'es': {
            'titulo': 'Richie Pasteles',
            'descripcion': 'Los mejores pasteles y postres para endulzar tu día.',
            'inicio': 'Inicio',
            'productos':'Productos',
            'contacto':'Contacto',
            'bienvenida':'Bienvenido a Richie Pasteles',
            'descrip':'Descubre nuestra deliciosa selección de pasteles y postres, a un increíble precio!',
            'produx':'Nuestros Productos',
            'telef':'Numero Celular',
            'correo':'Correo Electronico',
            'pie':'2023 Pastelería Delicioso. Todos los derechos reservados.',
            'pastel1':'Pastel de platano',
            'pastel1des':'Es un pastel de platano xd'
            // Agrega más traducciones según sea necesario
        },
        'en': {
            'titulo': 'Richie Cakes',
            'descripcion': 'The best cakes and desserts to sweeten your day.',
            'inicio': 'Home',
            'productos':'Products',
            'contacto':'Contact',
            'bienvenida':'Welcome to Richie Cakes',
            'descrip':'Find our delicious seleccion of cakes and deserts at an incredible price!',
            'produx':'Our Products',
            'telef':'Cellphone Number',
            'correo':'e-mail Address',
            'pie': '2023 Richie Cakes. All the rights reserved.',
            'pastel1':'Banana Cake',
            'pastel1des':'Its made of banana bread'
            // Add more translations as needed
        }
        // Puedes agregar más idiomas según sea necesario
    };

    // Función para cambiar el idioma
    function cambiarIdioma(idioma) {
        htmlElement.setAttribute('lang', idioma);
        actualizarTraducciones(idioma);
    }

    // Función para actualizar las traducciones
    function actualizarTraducciones(idioma) {
        var traduccionesActuales = traducciones[idioma];
        var elementosTraducibles = document.querySelectorAll('[data-translate]');

        elementosTraducibles.forEach(function (elemento) {
            var claveTraduccion = elemento.getAttribute('data-translate');
            if (traduccionesActuales && traduccionesActuales[claveTraduccion]) {
                elemento.textContent = traduccionesActuales[claveTraduccion];
            }
        });
    }

    // Event listeners para los botones de cambio de idioma
    var btnEspanol = document.getElementById('btnEspanol');
    var btnIngles = document.getElementById('btnIngles');

    btnEspanol.addEventListener('click', function () {
        cambiarIdioma('es');
    });

    btnIngles.addEventListener('click', function () {
        cambiarIdioma('en');
    });

    // Inicializar las traducciones
    actualizarTraducciones(idiomaActual);
});