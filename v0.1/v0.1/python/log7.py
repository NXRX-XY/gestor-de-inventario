import sys
import datetime

def registrar_actas(nombre_completo, acta):
    fecha_hora_actual = datetime.datetime.now()
    with open('../python/log.txt', 'a') as archivo_log:
        archivo_log.write(f'{fecha_hora_actual}: Usuario {nombre_completo} agregó la acta de trabajo N°{acta}\n')

# Recibir el argumento de línea de comandos (nombre completo)
if __name__ == "__main__":
    nombre_completo = sys.argv[1]
    acta = sys.argv[2]
    registrar_actas(nombre_completo, acta)
