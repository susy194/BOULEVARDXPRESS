document.addEventListener('DOMContentLoaded', (event) => {
    window.Echo.private("user.Chef")
        .listen('GetMesas', (e) => {
            const data = e.data;

            const { Num_m, id_pedido, id_prod, producto, cantidad, nota, estado } = data;

            if ( estado === 'Completado' ) {

                $.notify(
                    `Pedido de Mesa #${Num_m} completado`,
                    "info"
                );

                const mesa = document.getElementById(`mesa-${Num_m}`);

                const lis  = mesa.querySelectorAll('li');

                for (let i = lis.length-1; i > 0; i--) {
                    lis[i].remove();
                }

                mesa.querySelector('li').classList.remove('is-hidden');

                return;
            }

            if ( estado === 'eliminado' ) {
                const mesa = document.getElementById(`mesa-${Num_m}`);
                mesa.querySelector(`#prod-${id_prod}`).remove();

                $.notify(
                    `${producto} eliminado de Mesa #${Num_m}`,
                    "info"
                );

                const productos = mesa.querySelectorAll("li").length

                if ( productos === 1 ) {
                    mesa.querySelector('li').classList.remove('is-hidden');
                }

                return;
            }

            const mesa = document.getElementById(`mesa-${Num_m}`);
            const producto_existe = mesa.querySelector(`#prod-${id_prod}`);

            if ( producto_existe ) {
                return;
            }

            $.notify(
                "Producto agregado a Mesa #" + Num_m,
                "info"
            );

            mesa.querySelector('li').classList.add('is-hidden');

            const ul = mesa.querySelector('ul');
            const li = document.createElement('li');
            const p  = document.createElement('p');

            li.id = `prod-${id_prod}`;

            const button = document.createElement('button');
            button.classList.add('button', 'is-info', 'is-normal');
            button.textContent = 'Entregar producto';
            let content = `${producto} x ${cantidad}`;
            li.classList.add('is-size-5', 'is-flex', 'is-align-items-center', 'is-justify-content-space-between', 'marginleft-1', 'margin-right-1');

            if (nota) {
                content += ` ( ${nota} )`;
            }

            p.textContent = content;

            if ( estado === 'entregado' ) {
                button.disabled = true;
                button.textContent = 'Entregado';
                button.style.backgroundColor = 'green';
                button.style.cursor = 'default';

            } else {
                button.addEventListener('click', () => {
                    button.disabled = true;
                    button.textContent = 'Entregado';
                    button.style.backgroundColor = 'green';
                    button.style.cursor = 'default';

                    fetch(`/api/actualizarProducto/${id_pedido}/${id_prod}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                });
            }

            li.appendChild(p);
            li.appendChild(button);
            ul.appendChild(li);
        });
});


document.addEventListener('DOMContentLoaded', async (event) => {
    await sleep(2000);
    await fetch('/api/getmesas')
        .then(response => {
            console.log("");
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
