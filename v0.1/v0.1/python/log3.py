import sys
import datetime

def registrar_cierre_sesion(nombre_completo, usuario, documento):
    fecha_hora_actual = datetime.datetime.now()
    with open('../python/log.txt', 'a') as archivo_log:
        archivo_log.write(f'{fecha_hora_actual}: Usuario {nombre_completo} registró a {usuario} con el N° de documento {documento}\n')

# Recibir el argumento de línea de comandos (nombre completo)
if __name__ == "__main__":
    nombre_completo = sys.argv[1]
    usuario = sys.argv[2]
    documento = sys.argv[3]
    registrar_cierre_sesion(nombre_completo, usuario, documento)
