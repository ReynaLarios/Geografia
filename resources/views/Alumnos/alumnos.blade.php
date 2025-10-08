@extends('base.layout')

@section('contenido')

<section class="bg-white dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4">

        <!-- Título de la sección -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">ALUMNOS</h2>
            <hr class="mt-4 border-gray-300 dark:border-gray-700">
        </div>

        <!-- Texto completo del Artículo 20 -->
        <div class="text-gray-700 dark:text-gray-300 space-y-4 text-justify">
            <p>La Ley Orgánica de la Universidad de Guadalajara en su artículo 20 define lo que es un alumno así como las
                diversas categorías que puede tener al inscribirse:</p>

            <p class="font-bold">Artículo 20.</p>
            <p>Se considerará alumno a todo aquél que, cumpliendo los requisitos de ingreso establecidos por la
                normatividad aplicable, haya sido admitido por la autoridad competente y se encuentre inscrito en alguno de
                los programas académicos de la Universidad. Los alumnos que se inscriban en la Universidad pueden tener las
                categorías de ordinarios, especiales y oyentes.</p>

            <p>I. Son alumnos ordinarios los que se inscriben con la finalidad de adquirir un título o grado universitario.
                A su vez, pueden tener la calidad de regulares, irregulares y condicionales, en los siguientes términos:</p>
            <ul class="list-disc list-inside space-y-1">
                <li>Son alumnos ordinarios regulares, los que cuenten con la totalidad de los créditos obligatorios aprobados,
                    en los términos del Estatuto General;</li>
                <li>Son alumnos ordinarios irregulares, los que tengan créditos académicos obligatorios reprobados, en los
                    términos del Estatuto General;</li>
                <li>Son alumnos ordinarios condicionales, aquellos que hubiesen solicitado a la Universidad la revalidación o
                    reconocimiento de equivalencia de estudios previos, realizados en otra institución educativa y cuyo
                    expediente se encuentre en trámite.</li>
            </ul>

            <p>II. Obtener, mediante la acreditación de las respectivas pruebas de conocimiento y demás requisitos
                establecidos, el diploma, título o grado universitario correspondiente;</p>
            <p>III. Reunirse, asociarse y expresar dentro de la Universidad sus opiniones sobre los asuntos que a la
                Institución conciernan, sin más limitaciones que las de no interrumpir las labores universitarias y guardar
                el decoro y el respeto debidos a la Institución y a los miembros de su comunidad;</p>
            <p>IV. Formar parte de los órganos de gobierno de la Universidad;</p>
            <p>V. Realizar actividades en beneficio de la Institución;</p>
            <p>VI. Estudiar y cumplir con las demás actividades escolares o extraescolares derivadas de los planes y
                programas académicos;</p>
            <p>VII. Cooperar mediante sus aportaciones económicas, al mejoramiento de la Universidad, para que ésta pueda
                cumplir con la mayor amplitud su misión;</p>
            <p>VIII. Prestar, de acuerdo con su condición, el servicio social que la Universidad disponga;</p>
            <p>IX. Realizar actividades académicas en los términos de los planes y programas correspondientes;</p>
            <p>X. Las demás que establezcan los ordenamientos correspondientes. El Consejo General Universitario fijará las
                aportaciones respectivas, a que se refiere la fracción VII de este artículo, en el arancel que esta Ley y el
                Estatuto General establezcan. La carencia de recursos no será en ningún caso motivo para que se niegue el
                ingreso o permanencia en la Institución. Por ello en caso de necesidad comprobada, podrá autorizarse la
                condonación o aplazamiento de las aportaciones que correspondan al alumno, conforme a la reglamentación
                aplicable.</p>
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
