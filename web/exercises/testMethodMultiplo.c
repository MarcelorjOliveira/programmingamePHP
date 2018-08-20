#include <stdio.h> 
#include <stdlib.h> 
#include "CUnit/Basic.h" 
int multiplo(int x, int y){
 return 0;
}int init_suite(void) { 
return 0; 
} 
int clean_suite(void) { 
return 0; 
} 
void testaMultiplo() { 
CU_ASSERT(0 == multiplo(1,1)); 

                CU_ASSERT(1 == multiplo(1,100)); 

                CU_ASSERT(0 == multiplo(8,4)); 

                CU_ASSERT(1 == multiplo(3,2)); 
 
                CU_ASSERT(0 == multiplo(80,20)); 
 } 
int main() { 
CU_pSuite pSuite = NULL; 
    if (CUE_SUCCESS != CU_initialize_registry()) 
return CU_get_error(); 
    pSuite = CU_add_suite("newcunittest", init_suite, clean_suite); 
if (NULL == pSuite) { 
CU_cleanup_registry(); 
return CU_get_error(); 
} 
if (NULL == CU_add_test(pSuite, "testaMultiplo", testaMultiplo)) { 
CU_cleanup_registry(); 
return CU_get_error(); 
} 
CU_basic_set_mode(CU_BRM_VERBOSE); 
CU_automated_run_tests(); 
CU_cleanup_registry(); 
return CU_get_error(); 
} 
