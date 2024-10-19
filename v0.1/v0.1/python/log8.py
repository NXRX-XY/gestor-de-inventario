import sys
import datetime

def registrar_devolucion(nombre_completo, asignacion, tecnico):
    fecha_hora_actual = datetime.datetime.now()
    with open('../python/log.txt', 'a') as archivo_log:
        archivo_log.write(f'{fecha_hora_actual}: Usuario {nombre_completo} agregó la devolucion de {asignacion} del tecnico {tecnico}\n')

# Recibir el argumento de línea de comandos (nombre completo)
if __name__ == "__main__":
    nombre_completo = sys.argv[1]
    asignacion = sys.argv[2]
    tecnico = sys.argv[3]
    registrar_devolucion(nombre_completo, asignacion, tecnico)
