from fastapi import FastAPI
from pydantic import BaseModel
import uvicorn
from motor_ia import responder_busqueda # Importa tu función

app = FastAPI()

class Consulta(BaseModel):
    prompt: str

@app.post("/consultar")
def api_consultar(entrada: Consulta):
    # Usamos tu función de motor_ia.py
    respuesta = responder_busqueda(entrada.prompt)
    return {"respuesta": respuesta}

if __name__ == "__main__":
    # Escucha en el puerto 8000
    uvicorn.run(app, host="0.0.0.0", port=8000)