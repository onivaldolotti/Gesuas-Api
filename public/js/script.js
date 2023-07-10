const createCitizenForm = document.getElementById('createCitizenForm');
        const findCitizenForm = document.getElementById('findCitizenForm');
        const responseDiv = document.getElementById('response');

        createCitizenForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const name = document.getElementById('nameInput').value;

            fetch('http://localhost:8080/citizens', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name })
            })
            .then(response => response.json())
            .then(data => {
                responseDiv.innerText = 'Cidadão criado com sucesso. NIS: ' + data.nis;
            })
            .catch(error => {
                responseDiv.innerText = 'Erro ao criar cidadão: ' + error.message;
            });

            document.getElementById('nameInput').value = '';
        });

        findCitizenForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const nis = document.getElementById('nisInput').value;

            fetch('http://localhost:8080/citizens/' + nis)
            .then(response => {
                if (response.status === 200) {
                    return response.json();
                } else if (response.status === 404) {
                    throw new Error('Cidadão não encontrado');
                } else {
                    throw new Error('Erro ao buscar cidadão');
                }
            })
            .then(data => {
                if(data.message){
                    throw new Error(data.message);
                }
                
                responseDiv.innerText = 'Nome: ' + data.name + ', NIS: ' + data.nis;
            })
            .catch(error => {
                responseDiv.innerText = error.message;
            });

            document.getElementById('nisInput').value = '';
        });