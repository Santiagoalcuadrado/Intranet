import pandas as pd

def obtener_datos_bpez():
    # Cantidad total de elementos: 30 preguntas y 30 respuestas.
    data = {
        'pregunta_clave': [
            '¿Cuál es el horario de atención y apertura al ciudadano?', #1
            '¿A qué hora abren y cierran la biblioteca?', #2
            '¿Cuándo se fundó la biblioteca y quién la fundó?', #3
            '¿Cuál es la historia de la Biblioteca Pública del Estado Zulia?', #4
            '¿Qué servicios ofrece la biblioteca?', #5
            '¿Ofrecen cursos de alfabetización tecnológica?', #6
            '¿Cómo funciona el préstamo de libros y computadoras?', #7
            '¿Cuántas salas o áreas tiene la biblioteca?', #8
            '¿Qué es la sala de Acervo Histórico?', #9
            '¿Qué servicios ofrece la Sala Braille?', #10
            '¿Qué es la Fonoteca y Videoteca?', #11
            '¿Cuál es la página web oficial y cómo los localizo?', #12
            '¿Dónde puedo encontrar información en línea?', #13
            'fundacion historia fundadores 1873 venancio pulgar', #14
            'salas areas espacios nombres epónimos', #15
            '¿En qué parte encuentro la información de los cargos?', #16
            '¿Dónde está el menú de Organización?', #17
            '¿Cómo puedo ver los procedimientos de la biblioteca?', #18
            '¿Dónde encuentro la misión visión y valores?', #19
            '¿Dónde están las opciones de cargos y manuales?', #20
            '¿Qué es la Bibliocafé?', #21
            '¿Quién fue María Calcaño?', #22
            '¿Qué es la Sala Digital Humberto Fernández Morán?', #23
            '¿Qué es la Sala Infantil Amenodoro Urdaneta?', #24
            '¿Qué es la Hemeroteca Eduardo López Rivas?', #25
            '¿Dónde veo la planificación y los proyectos?', #26
            '¿Dónde están los informes de gestión y reportes?', #27
            '¿En qué parte están las reuniones gerenciales?', #28
            '¿Dónde encuentro las leyes y documentos de seguridad?', #29
            '¿Qué hay en el módulo de Gestión Estratégica?', #30
            '¿Qué encuentro en el menú de Control?', #31
            '¿Cómo accedo a los reportes de actividades?', #32
            '¿Dónde está la información de seguridad institucional?', #33
            '¿Existe la sala de robótica actualmente?', #34
            'menu navegacion dropdown opciones' #35
        ],
        'respuesta_oficial': [
            'La biblioteca atiende de lunes a viernes, en un horario de 8:00 AM a 4:00 PM.', #1
            'El horario de atención continua es de lunes a viernes, de 8:00 AM a 4:00 PM.', #2
            'Fue fundada el 15 de julio de 1873 por decreto del General Venancio Pulgar.', #3
            'Nació en 1873 como Biblioteca Zuliana. En 1995 se nombró María Calcaño y su sede actual es de 2008.', #4
            'Ofrecemos alfabetización tecnológica, préstamo interno de libros y acceso a salas digitales.', #5
            'Sí, la Sala Digital ofrece programas de formación tecnológica gratuita para la comunidad.', #6
            'El préstamo es interno para consulta en sala, junto con el uso de equipos de computación.', #7
            'Contamos con Salas de Lectura, Infantil, Braille, Digital, Hemeroteca, Fonoteca y Videoteca.', #8
            'El Acervo Histórico custodia la memoria documental y registros antiguos del Estado Zulia.', #9
            'La Sala Braille Miguel Ángel Jusayú ofrece tecnología adaptada para personas con discapacidad visual.', #10
            'La Fonoteca Ulises Acosta y Videoteca Manuel Trujillo Durán resguardan el patrimonio audiovisual zuliano.', #11
            'Nuestra página web oficial es https://www.bibliotecapublicadelzulia.org/', #12
            'Puedes realizar consultas digitales en nuestro portal: https://www.bibliotecapublicadelzulia.org/', #13
            'La BPEZ fue fundada en 1873 por Venancio Pulgar y es patrimonio cultural del Zulia.', #14
            'Las salas llevan nombres de ilustres como María Calcaño, Jusayú, Fernández Morán y López Rivas.', #15
            'Los Cargos están en el menú superior: La Organización > Cargos.', #16
            'El menú Organización está arriba a la izquierda; allí verás Misión, Visión y Valores.', #17
            'Los procedimientos están en el menú: La Organización > Procedimientos.', #18
            'La Misión, Visión y Valores están en el menú superior: La Organización > Organización.', #19
            'Cargos y manuales se encuentran en el menú desplegable de La Organización.', #20
            'La Bibliocafé es un espacio para leer disfrutando de un café en un ambiente relajado.', #21
            'María Calcaño fue una destacada poetisa zuliana cuyo nombre honra nuestra institución.', #22
            'La Sala Digital Fernández Morán es el centro de investigación y formación tecnológica.', #23
            'La Sala Infantil Amenodoro Urdaneta fomenta la lectura en niños de 5 a 14 años.', #24
            'La Hemeroteca Eduardo López Rivas facilita la consulta de diarios y periódicos regionales.', #25
            'La Planificación y Proyectos están en el menú superior: Gestión Estratégica.', #26
            'Los Informes de Gestión y Reportes están en el menú superior: Control.', #27
            'Las actas y detalles de Reuniones Gerenciales están en el menú: Gestión Estratégica.', #28
            'Las leyes y normas están en el menú de Seguridad (te recomiendo hacerlo dropdown para verlas todas).', #29
            'En Gestión Estratégica encuentras Planificación, Proyectos y Reuniones Gerenciales.', #30
            'En el menú de Control puedes acceder a Reportes de Actividades e Informes de Gestión.', #31
            'Los reportes de actividades se encuentran dentro del menú desplegable Control.', #32
            'La información de seguridad y leyes se encuentra en el botón/menú de Seguridad a la derecha.', #33
            'No, la sala de robótica ya no existe; fue sustituida por nuevos servicios digitales.', #34
            'Puedes usar los menús superiores: La Organización, Gestión Estratégica, Control y Seguridad.' #35
        ]
    }

    # --- LÍNEAS COMENTADAS PARA FUTURAS AMPLIACIONES ---
    # Pregunta futura 1: ¿Cómo subir un nuevo procedimiento?
    # Pregunta futura 2: ¿Dónde descargo mi recibo de pago?
    # Pregunta futura 3: ¿Cómo solicitar vacaciones desde la intranet?
    # Pregunta futura 4: Directorio telefónico interno
    # Pregunta futura 5: Reglamento interno de trabajo

    return pd.DataFrame(data)