#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <pthread.h>
#include <string.h>
#define	MAX		5000
#define	TIME_LOOP	50000

void* thread_function1(void*);
void* thread_function2(void*);
void* thread_function3(void*);

int	grade[MAX];
char msg[] = "Hello World";

int main() {
	int res;
	int i,j;
	pthread_t a_thread;
	pthread_t b_thread;
	pthread_t c_thread;
	void* thread_result;

	res = pthread_create(&a_thread, NULL, thread_function1, (void*)msg);
	if(res != 0) {
		perror("Thread1 creation failed\n");
		exit(EXIT_FAILURE);
	}
	res = pthread_create(&b_thread, NULL, thread_function2, (void*)msg);
	if(res != 0) {
		perror("Thread2 creation failed\n");
		exit(EXIT_FAILURE);
	}
	res = pthread_create(&c_thread, NULL, thread_function3, (void*)msg);
	if(res != 0) {
		perror("Thread3 creation failed\n");
		exit(EXIT_FAILURE);
	}

	printf("\nWaiting for thread1 to finish...\n");
	res = pthread_join(a_thread, &thread_result);
	if(res != 0) {
		perror("Thread1 join failed\n");
		exit(EXIT_FAILURE);
	}

	printf("\nThread1 joined, it returend %s\n", (char*)thread_result);
	printf("Message is now %s\n", msg);

	printf("\nWaiting for thread2 to finish...\n");
	res = pthread_join(b_thread, &thread_result);
	if(res != 0) {
		perror("Thread2 join failed\n");
		exit(EXIT_FAILURE);
	}
	printf("\nThread2 joined, it returend %s\n", (char*)thread_result);
	printf("Message is now %s\n", msg);

	printf("\nWaiting for thread3 to finish...\n");
	res = pthread_join(c_thread, &thread_result);
	if(res != 0) {
		perror("Thread3 join failed\n");
		exit(EXIT_FAILURE);
	}
	printf("\nThread3 joined, it returend %s\n", (char*)thread_result);
	printf("Message is now %s\n", msg);
	printf("\n\n ---------- Result Grade Matrix ---------- \n\n");
	i=0;
	while( i<MAX )
	{
		printf("%3d ~ %3d --> ", i, i+99);
		for(j=0; j<100; j++)
		{
			printf("%d ", grade[i]);
			i++;
		}
		printf("\n");
	}
	exit(EXIT_SUCCESS);
}

void* thread_function1(void* arg) {
	int i,j;
	printf("thread_function1 is running. Argument was %s\n", (char*)arg);
	sleep(1);
	for(j=0;j<MAX;j++)
	{
		grade[j]=1;
		for(i=1;i<TIME_LOOP;i++);
	}
	printf("\n");
	strcpy(msg, "Bye thread1!");
	pthread_exit("Thank you Thread1 for the CPU time!");
}
void* thread_function2(void* arg) {
	int i,j;
	printf("thread_function2 is running. Argument was %s\n", (char*)arg);
	sleep(1);
	for(j=0;j<MAX;j++)
	{
		grade[j]=2;
		for(i=1;i<TIME_LOOP;i++);
	}
	printf("\n");
	strcpy(msg, "Bye thread2!");
	pthread_exit("Thank you Thread2 for the CPU time!");
}
void* thread_function3(void* arg) {
	int i,j;
	printf("thread_function3 is running. Argument was %s\n", (char*)arg);
	sleep(1);
	for(j=0;j<MAX;j++)
	{
		grade[j]=3;
		for(i=1;i<TIME_LOOP;i++);
	}
	printf("\n");
	strcpy(msg, "Bye thread3!");
	pthread_exit("Thank you Thread3 for the CPU time!");
}
