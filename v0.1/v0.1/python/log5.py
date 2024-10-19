import sys
import datetime

def eliminar_guias(nombre_completo, guia, asignacion):
    fecha_hora_actual = datetime.datetime.now()
    with open('../python/log.txt', 'a') as archivo_log:
        archivo_log.write(f'{fecha_hora_actual}: Usuario {nombre_completo} elimino la guia N°{guia} de {asignacion}\n')

# Recibir el argumento de línea de comandos (nombre completo)
if __name__ == "__main__":
    nombre_completo = sys.argv[1]
    guia = sys.argv[2]
    asignacion = sys.argv[3]
    eliminar_guias(nombre_completo, guia, asignacion)
