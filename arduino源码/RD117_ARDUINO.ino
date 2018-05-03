
#include <Arduino.h>
#include "algorithm.h"
#include "max30102.h"

#define MAX_BRIGHTNESS 255


uint16_t aun_ir_buffer[100]; //infrared LED sensor data
uint16_t aun_red_buffer[100];  //red LED sensor data
int32_t n_ir_buffer_length; //data length
int32_t n_spo2;  //SPO2 value
int8_t ch_spo2_valid;  //indicator to show if the SPO2 calculation is valid
int32_t n_heart_rate; //heart rate value
int8_t  ch_hr_valid;  //indicator to show if the heart rate calculation is valid
uint8_t uch_dummy;


// the setup routine runs once when you press reset:
void setup() {

  maxim_max30102_reset(); //resets the MAX30102
  // initialize serial communication at 115200 bits per second:
  Serial.begin(9600);
  pinMode(10, INPUT);  //pin D10 connects to the interrupt output pin of the MAX30102
  delay(1000);
  maxim_max30102_read_reg(REG_INTR_STATUS_1,&uch_dummy);  //Reads/clears the interrupt status register
  uch_dummy=Serial.read();
  maxim_max30102_init();  //initialize the MAX30102
}
void dateget()
{
  uint32_t un_min, un_max, un_prev_data, un_brightness;  //variables to calculate the on-board LED brightness that reflects the heartbeats
  int32_t i=0;
  int n_spo2_total=0,n_heart_rate_total=0;
  float f_temp;
  
  un_min=0x3FFFF;
  un_max=0;
  n_ir_buffer_length=60;  //buffer length of 100 stores 4 seconds of samples running at 25sps

  //dumping the first 25 sets of samples in the memory and shift the last 75 sets of samples to the top
    for(i=15;i<100;i++)
    {
      aun_red_buffer[i-15]=aun_red_buffer[i];
      aun_ir_buffer[i-15]=aun_ir_buffer[i];

      //update the signal min and max
      if(un_min>aun_red_buffer[i])
        un_min=aun_red_buffer[i];
      if(un_max<aun_red_buffer[i])
        un_max=aun_red_buffer[i];
    }

    //take 25 sets of samples before calculating the heart rate.
    for(i=45;i<100;i++)
    {
      un_prev_data=aun_red_buffer[i-1];
      while(digitalRead(10)==1);
      digitalWrite(9, !digitalRead(9));
      maxim_max30102_read_fifo((aun_red_buffer+i), (aun_ir_buffer+i));

      //calculate the brightness of the LED
      if(aun_red_buffer[i]>un_prev_data)
      {
        f_temp=aun_red_buffer[i]-un_prev_data;
        f_temp/=(un_max-un_min);
        f_temp*=MAX_BRIGHTNESS;
        f_temp=un_brightness-f_temp;
        if(f_temp<0)
          un_brightness=0;
        else
          un_brightness=(int)f_temp;
      }
      else
      {
        f_temp=un_prev_data-aun_red_buffer[i];
        f_temp/=(un_max-un_min);
        f_temp*=MAX_BRIGHTNESS;
        un_brightness+=(int)f_temp;
        if(un_brightness>MAX_BRIGHTNESS)
          un_brightness=MAX_BRIGHTNESS;
      }

      //send samples and calculation result to terminal program through UART
      if (0<n_heart_rate&&0<n_spo2)
      {
         n_spo2_total+=n_spo2;
         n_heart_rate_total+=n_heart_rate;
      }
      //Serial.print(n_heart_rate, DEC);
      
      //Serial.print(n_spo2, DEC);
    }
      maxim_heart_rate_and_oxygen_saturation(aun_ir_buffer, n_ir_buffer_length, aun_red_buffer, &n_spo2, &ch_spo2_valid, &n_heart_rate, &ch_hr_valid); 
      Serial.print(n_heart_rate_total/60, DEC);
      Serial.print('|');
      Serial.print(n_spo2_total/60, DEC);
      Serial.print('|');
}


// the loop routine runs over and over again forever:
void loop() {
  int ReceiveByte;
  //Continuously taking samples from MAX30102.  Heart rate and SpO2 are calculated every 1 second
 if (Serial.available()> 0) 
   {   //串口是否有输入
            ReceiveByte = Serial.read();
            switch(ReceiveByte){
                case 0x30: {
                  dateget();
                };break;
            }
   }
}
 
