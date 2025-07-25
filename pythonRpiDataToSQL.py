#!/usr/bin/env python

import time
import board
import busio
import datetime
import MySQLdb
import adafruit_ads1x15.ads1115 as ADS
from adafruit_ads1x15.analog_in import AnalogIn

# General settings
prog_name = "shewaLogger.py"

# Settings for database connection
hostname = 'localhost'
username = 'zprodorg_pzg'
password = 'chapelCrymlyn2MFCs'
database = 'zprodorg_two_MFCs_DB'

# Initialize I2C and ADS1115 ADC
i2c = busio.I2C(board.SCL, board.SDA)
ads = ADS.ADS1115(i2c)

# Select Analog Input Channel (A0)
channel0 = AnalogIn(ads, ADS.P0)
channel1 = AnalogIn(ads, ADS.P1)

# Routine to insert temperature records into the pidata.temps table:
def insert_record( MFC1 ):
	query = "INSERT INTO MFCs_table (MFC1) " \
                "VALUES (%s,%s)"
    	args = (channel0)

    	try:
        	conn = MySQLdb.connect( host=hostname, user=username, passwd=password, db=database )
		cursor = conn.cursor()
        	cursor.execute(query, args)
		conn.commit()

    	except Exception as error:
        	print(error)

    	finally:
        	cursor.close()
        	conn.close()

# Print welcome 
print('[{0:s}] starting on {1:s}...'.format(prog_name, datetime.datetime.today().strftime('%Y-%m-%d %H:%M:%S')))

# Main loop
try:
	while True:
        print(f"Raw Value0: {channel0.value}, Voltage0: {channel0.voltage:.3f}V")
        print(f"Raw Value1: {channel1.value}, Voltage1: {channel1.voltage:.2f}V")
        now = datetime.datetime.now()
	date = now.strftime('%Y-%m-%d %H:%M:%S')
	insert_record(device,str(date),format(temp,'.2f'),format(hum,'.2f'))
	time.sleep(20)

except (IOError,TypeError) as e:
	print("Exiting...")

except KeyboardInterrupt:  
    	# here you put any code you want to run before the program   
    	# exits when you press CTRL+C  
	print("Stopping...")

finally:
	print("Cleaning up...")  
	GPIO.cleanup() # this ensures a clean exit


#
# This code is derived from the excellent tutorial "Visualize Your Sensor Readings from Anywhere in the World (ESP32/ESP8266 + MySQL + PHP)" by
#  Rui Santos aka randomnerd

#  Complete project details at https://randomnerdtutorials.com/visualize-esp32-esp8266-sensor-readings-from-anywhere/
  
#  Permission is hereby granted, free of charge, to any person obtaining a copy
#  of this software and associated documentation files.
  
#  The above copyright notice and this permission notice shall be included in all
#  copies or substantial portions of the Software.
