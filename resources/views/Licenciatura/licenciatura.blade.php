 @extends('base.layout')

@section('contenido')
<section class="bg-white dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Título de la sección -->
        <div class="text-center mb-8">
            <h2 class="font-extrabold text-gray-900 dark:text-white">
                LICENCIATURA EN GEOGRAFÍA/CIENCIAS
            </h2>
            <hr class="mt-4 border-gray-300 dark:border-gray-700">
        </div>

        <p>
            Consulta los requisitos de ingreso en el siguiente vínculo:
            <a href="http://www.udg.mx/es/aspirantes/registro-de-tramites" target="_blank" class="text-blue-600 underline">
                http://www.udg.mx/es/aspirantes/registro-de-tramites
            </a>
        </p>

        <p class="fw-bold mt-4">Presentación</p>

        <p>
            El plan de estudios de la Licenciatura en Geografía fue aprobado por el H. Consejo General Universitario con el
            Dictamen Núm. I/2006/366 con acuerdo al diseño curricular por competencias y bajo el sistema de créditos.
            Responde a la formación de recursos humanos capaces de reconstruir los procesos territoriales y generar los
            conocimientos geográficos, dinámicas y problemática de la interacción sociedad-naturaleza a diferentes escalas
            de análisis y cartográficas, especialmente de Jalisco y el Occidente de México.
        </p>

        <p class="fw-bold mt-4">
            Las competencias sobre las que gira el plan de estudios incorporan los avances de la disciplina en la ordenación territorial:
        </p>

        <p>
            1. La aplicación de las tecnologías de la información y comunicaciones (Sistemas de Información Geográfica, con
            la observación remota de la Superficie de la Tierra y la representación cartográfica), aplicadas al análisis
            espacial.
        </p>

        <p>
            2. Gestión del Ordenamiento Territorial (Evaluar y mejorar el funcionamiento del Sistema Territorial que
            generen condiciones de equilibrio y sustentabilidad).
        </p>

        <p>
            3. La investigación. El alumno adquiere conocimientos teóricos y metodológicos que le permitan realizar
            proyectos de investigación, encaminados a abordar aspectos orientados al Ordenamiento Territorial y Ambiental
            desde su visión geográfica.
        </p>

        <p>
            4. La docencia. Los alumnos adquieren conocimientos geográficos esenciales, las formas de aplicar la
            metodología y las herramientas didácticas para el desempeño como profesor en los niveles superior, medio
            superior y básico. Son competencias que se concretan con la incorporación de destrezas y habilidades que adquieren
            sus egresados, con objeto de que se incorporen a los mercados de trabajo.
        </p>

        <p>
            El abanico de alternativas laborales que cubren diversos temas como la creciente expansión de las ciudades, la
            presión de áreas rurales, la desarticulación de la producción agropecuaria, los riesgos ambientales, las disputas
            por el agua, la contaminación del aire, ríos y lagos, la conservación y protección de áreas naturales, el cambio
            climático, los efectos en la salud pública, pobreza, desigualdad y en general la calidad de vida.
        </p>

        <p>
            La amplia diversidad de problemas y conflictos que enfrenta la sociedad actual; empero, son abordados por la
            comunidad de geógrafos con respuestas teóricas y metodológicas diferentes, pero con una matriz común.
            Localizaciones absolutas, la herramienta de representación por excelencia del geógrafo como el mapa;
            localizaciones relativas que establecen la conexión de hechos, fenómenos y procesos geográficos; identificar
            patrones de distribución espacial en el territorio y acercamientos analíticos a los lugares. Los geógrafos
            formados en nuestras aulas adquieren competencias que les permiten leer la realidad, identificar sus problemas y
            proponer alternativas de solución a los conflictos y tensiones de los territorios.
        </p>

        <p class="fw-bold mt-4">MODALIDAD</p>

        <p>
            La oferta académica de la Universidad de Guadalajara está organizada con base en el sistema de créditos y el
            plan de estudios de la Licenciatura en Geografía lo incorpora al ofrecer una mayor flexibilidad,
            diversificación de las opciones formativas e incorporando autonomía a los alumnos en cuanto a la
            responsabilidad y compromiso en el proceso de enseñanza-aprendizaje y su formación profesional.
            Otra ventaja del sistema de créditos es que potencia las necesidades e intereses vocacionales y expectativas de
            los estudiantes inscritos en los programas, al tiempo que permite que los propios alumnos cubran los
            requerimientos de los programas educativos a su propio ritmo.
        </p>
    </div>

    <!-- 🔧 Ajuste del tamaño de texto -->
    <style>
        section p {
            font-size: 13px !important;
            line-height: 1.6 !important;
            color: #374151 !important; 
        }

        section h2 {
            font-size: 20px !important;
        }
    </style>
</section>
@endsection
