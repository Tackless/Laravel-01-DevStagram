import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: '.png, .jpg, .jpeg, .gif',
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        const nameImagen = document.querySelector('[name="imagen"]').value;
        if (nameImagen.trim()) {
            const imagenPublicada = {};
            imagenPublicada.size = 1234; // Configuración obligatoria, números sin importancia
            imagenPublicada.name = nameImagen;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classlist.add('dz-succes', 'dz-complete');
        }
    }
});

dropzone.on('success', function(file, response) {
    console.log(response.imagenes);
    document.querySelector('[name="imagen"]').value = response.imagenes;
    
});

dropzone.on('removedfile', function() {
    document.querySelector('[name="imagen"]').value = '';
});