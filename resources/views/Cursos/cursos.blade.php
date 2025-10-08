@extends('base.layout')

@section('contenido')
    <section class="bg-white dark:bg-gray-900 py-8">
        <div class="container mx-auto px-4">
            <!-- Título de la sección -->
            <div class="text-center mb-8">
                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white">PROGRAMA DE BIENVENIDA PARA ALUMNOS DE 1ER
                    INGRESO</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2"></p>
                <hr class="mt-4 border-gray-300 dark:border-gray-700">
            </div>

            <p class="fw-bold">CURSOS DE INDUCCIÓN </p>

            <p class="text-gray-500 dark:text-gray-400 mt-2"></p>
            En febrero del año 2007 se estableció el programa de bienvenida académica a los alumnos de primer ingreso a la
            licenciatura en Geografía, los Cursos de Inducción se imparten cada inicio de calendario “A” y “B” del año
            escolar de la Universidad de Guadalajara.
            <p></p>
            <p> Para impartir los Cursos de Inducción se elabora material informativo actualizado (Manual de información
                básica para alumnos de primer ingreso de Licenciatura en Geografía) </p>
            <p> 1.- Portada con el logo del Departamento de Geografía y Ordenación Territorial, la dirección de la página de
                la Licenciatura, el correo de la Coordinación de Extensión y el facebook de la Licenciatura, con los
                logotipos de la Universidad de Guadalajara, del CUCSH y de la División de Estudios Históricos y Humanos.
            </p>
            <p> 2.- Bienvenida donde se lee la importancia de ser geógrafo, lo que estudia la geografía, lo que proporcionan
                las cuatro competencias profesionales donde están escritas dentro del diseño de cuatro esferas o mundos:
                Ordenamiento Territorial, Cartografía y Sistemas de Información Geográfica, Investigación básica y aplicada
                en Geografía y Docencia.</p>
            <p> 3.- Programa del Curso de Inducción </p>
            <p> 4.- Guía o pasos a seguir la cual tiene seis puntos importantes para que el nuevo alumno conozca que hacer
                en cuanto llegue al Departamento.</p>
                <p>*Indica la fecha, el horario y el lugar de asistencia a tomar el Curso de Inducción
                <p>* Se les dice que acudan con el Coordinador de Tutorías para el llenado de ficha básica de datos personales
                así como se les será asignado un profesor que será su tutor en la carrera. Se les facilita la ubicación y
                los horarios en que pueden ser recibidos por el Coordinador de Tutorías.</p>
                <p>*Asistir con el Coordinador de Carrera para que conozcan su NIP y se les auxilie a organizar su horario
                dentro del SIIAU. Les ayuda a disipar cualquier duda sobre la navegación en el SIIAU, sobre las materias así
                como los horarios.</p>
                <p>*También les indica cómo obtener el formato de pago en el sistema SIIAU, ingresando el código universitario
                y NIP en alumnos/estado de cuenta /formato de pago, imprimir hacer el pago en el banco correspondiente,
                después acudir a la ventanilla de Control Escolar para entregar el recibo y posteriormente le tomaran la
                fotografía para elaborar la credencial de alumno de CUCSH con holograma.</p>
                <p> 5.-Croquis del CUCSH ubicando los lugares relevantes tales como  la  Rectoría, biblioteca, auditorios, control escolar y módulos de aulas.</p>
                <p> 6.-Solicitud de correo personal entregar a la Coordinación de Extensión y Difusión, esto con el fin de agregar a la base de datos de difusión para que el alumno pueda recibir los comunicados e información académica y administrativa relacionada con la Licenciatura en Geografía. </p>
                <p> 7.-Horario de materias especial para los alumnos de primer ingreso a partir del cul organizar su propio horario. </p>
                <p> 8.-Formato que contiene las obligaciones y derechos de los alumnos como asistentes a las prácticas de campo. </p>

  <!-- Tabla interactiva de archivos -->
        <div class="page-container mt-6">
            <style>
                .table-cebra {
                    width: 100%;
                    border-collapse: collapse;
                }
                .table-cebra th,
                .table-cebra td {
                    border: 1px solid #ccc;
                    padding: 8px 12px;
                    text-align: left;
                }
                .table-cebra tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                .table-cebra th {
                    background-color: #6b422d;
                    color: white;
                }
                .archivo-input {
                    width: 100%;
                }
                .archivo-tamano {
                    text-align: center;
                    font-weight: bold;
                }
            </style>

            <table class="table-cebra" id="tabla-archivos">
                <thead>
                    <tr>
                        <th>Adjunto</th>
                        <th>Tamaño</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" class="archivo-input" />
                        </td>
                        <td class="archivo-tamano">0 MB</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>

        <!-- Script para actualizar tamaño -->
       <script>
    document.querySelectorAll('.archivo-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const file = input.files[0];
            const sizeCell = input.closest('tr').querySelector('.archivo-tamano');
            if(file) {
                // Convierte bytes a MB
                let sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                sizeCell.textContent = sizeInMB + ' MB';
            } else {
                sizeCell.textContent = '0 MB';
            }
        });
    });
</script>
    </div>
</section>

            @endsection
