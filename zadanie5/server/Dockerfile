FROM golang:1.22

WORKDIR /usr/src/app

COPY go.mod ./
RUN go mod download && go mod verify

COPY . .

CMD ["go", "run", "server.go"]

