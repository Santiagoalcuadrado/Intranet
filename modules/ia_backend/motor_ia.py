from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from datos_bpez import obtener_datos_bpez

# Cargamos los datos
df = obtener_datos_bpez()
vectorizador = TfidfVectorizer()
# El motor "aprende" los patrones de las preguntas clave
matriz_conocimiento = vectorizador.fit_transform(df['pregunta_clave'])

def responder_busqueda(consulta_usuario):
    # Traducimos la pregunta del usuario a números
    vector_usuario = vectorizador.transform([consulta_usuario])
    
    # Calculamos la "distancia" (similitud) entre la duda y el conocimiento
    similitudes = cosine_similarity(vector_usuario, matriz_conocimiento)
    indice_mejor_match = similitudes.argmax()
    puntuacion = similitudes[0][indice_mejor_match]

    # Si la confianza es mayor al 20%, respondemos con autonomía
    if puntuacion > 0.2:
        return df.iloc[indice_mejor_match]['respuesta_oficial']
    else:
        return "Lo siento, soy el motor local de la BPEZ y no tengo esa información aún."