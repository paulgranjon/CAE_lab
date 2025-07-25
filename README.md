# CAE_lab
MFC data logging device

The device monitors the voltage from 4 microbial fuel cells - voltage generated by bacterial activity near the electrodes in each cell.

The microbial fuel cells are connected to an analog to digital converter module [ https://wiki.seeedstudio.com/Grove-16-bit-ADC-ADS1115 ]. 

The A/D converter is connected to a Raspberry Pi that runs a python script (voltagesToSQL.py). The script reads the 4 outputs from the A/D converter, returns 4 voltage values in millivolts. 

The voltages are displayed on the raspberry pi console and simultaneously posted to a remote php script (voltages_post_data.php) that inserts the voltage data in a SQL database. 

Another php script (voltages_display_data.php) displays the data on a web page in a graph powered by highcharts.com.

===========================

The project was partly funded by Cardiff School of Art and Design and by the Learned Society of Wales, 2025. 

The prototype was deployed in the lab of the Centre for Art and Ecology, Goldsmiths University London 2025.



