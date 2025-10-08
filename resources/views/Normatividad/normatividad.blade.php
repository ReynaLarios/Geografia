 @extends('base.layout')

 @section('contenido')


 <section class="bg-white dark:bg-gray-900 py-8">
         <div class="container mx-auto px-4">
             <!-- Título de la sección -->
             <div class="text-center mb-8">
                 <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white">NORMATIVIDAD</h3>
                 <p class="text-gray-500 dark:text-gray-400 mt-2"></p>
                 <hr class="mt-4 border-gray-300 dark:border-gray-700">
             </div>

<p class="text-gray-500 dark:text-gray-400 mt-2"></p>
             El plan de estudios de la Licenciatura en Geografía fue aprobado por el H. Consejo General Universitario con el
             Dictamen Núm. I/2006/366 con acuerdo al diseño curricular por competencias y bajo el sistema de créditos.
             Responde a la formación de recursos humanos capaces de reconstruir los procesos territoriales y generar los
             conocimientos geográficos, dinámicas y problemática de la interacción sociedad naturaleza a diferentes escalas
             de análisis y cartográficas, especialmente de Jalisco y el Occidente de México. </p>
             <p></p>
               

         </div>

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