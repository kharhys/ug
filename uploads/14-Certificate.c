#include<stdio.h>
#include<string.h>
struct book{
char title[26];
char author[26];
char publisher[10];
int code[8];
int year[8];
}books;
main(){
/*7911d529535d*/
printf("Enter Book Title: ");
scanf("%c\n",title);
printf("Enter Book author: ");
scanf("%c\n",author);
printf("Enter Book publisher: ");
scanf("%c\n",publisher);
printf("Enter Book code: ");
scanf("%c\n",code);
printf("Enter Book year: ");
scanf("%c\n",year);
printf("-------------------------");
printf("Title :%c",book.title);
printf("Title :%c",book.author);
printf("Title :%c",book.publisher);
printf("Title :%c",book.code);
printf("Title :%c",book.year);
}
