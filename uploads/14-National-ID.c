#include <stdio.h>
#include <string.h>
#include <stdlib.h>


void valid_digits();



int main(){

valid_digits();
}



void valid_digits(){

char phone_number[20];
double number;
char str[20],str1[20];
char phone_number_long[20];

memset(phone_number,0,sizeof(phone_number));
memset(phone_number_long,0,sizeof(phone_number_long));
number=0;
printf("Enter the Phone number\n");
scanf("%lf",&number);
sprintf(phone_number_long,"%lf",number);


//int x=strlen(phone_number_long);
if(strlen(phone_number_long)>16){

snprintf(phone_number,13,"%s",phone_number_long);
snprintf(str1,5,"%s",phone_number);
}

else{
snprintf(phone_number,10,"%s",phone_number_long);
snprintf(str,2,"%s",phone_number);
}

//int x=strlen(phone_number);
if((strcmp(str,"7")==0 && strlen(phone_number)==9)|| (strcmp(str1,"2547")==0 && strlen(phone_number)==12))

{


printf("\nThe phone number %s is valid.\n\n",phone_number);

return;

}

else{



printf("The phone number %s is invalid.\nPress any key and try again!\n\n",phone_number);
valid_digits();



}


}

