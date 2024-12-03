package main

import (
	"fmt"
	"net"
	"os"
	"strings"
	"time"
)

var minPort = 1
var maxPort = 65536

func main() {

	if len(os.Args) != 2 {
		fmt.Println("Usage: go run main.go <ip>")
		os.Exit(1)
	}

	ipToScan := os.Args[1]

	// fmt.Println("-" * 50)
	fmt.Println(strings.Repeat("-", 50))
	fmt.Println("Scanning " + ipToScan + " for open ports...")
	fmt.Println("time started: " + time.Now().Format("2006-01-02 15:04:05"))
	fmt.Println(strings.Repeat("-", 50))

	activeThreads := 0
	doneChannel := make(chan bool)

	for port := minPort; port <= maxPort; port++ {
		go scanPort(ipToScan, port, doneChannel)
		// fmt.Println(activeThreads, "active threads")
		activeThreads++
	}

	for activeThreads > 0 {
		<-doneChannel
		activeThreads--
		// fmt.Println(activeThreads, "deactive threads")
	}

}

func scanPort(ip string, port int, doneChannel chan bool) {
	_, err := net.DialTimeout("tcp", fmt.Sprintf("%s:%d", ip, port), time.Second*10)
	if err == nil {
		fmt.Printf("Host %s has open port %d\n", ip, port)
	}
	doneChannel <- true
}
