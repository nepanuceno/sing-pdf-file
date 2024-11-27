# RSA-certified PDF file signer

WEB system to batch sign PDF files with RSA certificate.

## Run WEB Application
``` 
docker-compose up -d
```
## How to Generate a Compatible RSA Key

- Access the online system ```https://getacert.com/getacert.html```.
- Fill in the form with the respective information and then click on the "Next Page" button.
- Download the files with the extensions .cer, .csr e.pkey.
- In the "certified" directory at the root of the project, create a file with the .crt extension and paste the contents of the files that .cer, .csr, and .pkey into the .crt file.
  
### Help
- To understand better, open the cert.crt file inside the certified directory and observe the way the content is.