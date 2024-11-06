<?php

    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
    
    class ProductControllerTest extends WebTestCase{

        public function testIndex(){
            $client = static::createClient();
            $client->request('GET', 'api/products');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertIsArray(json_decode($client->getResponse()->getContent(), true));
        }

        public function testIndexError(){
            $client = static::createClient();
            $client->request('GET', 'api/app/products');
            $this->assertEquals(400, $client->getResponse()->getStatusCode());
            $this->assertNull(json_decode($client->getResponse()->getContent(), true));
        }

        public function testCreate(){
            $client = static::createClient();
            $client->request('POST', 'api/products', [], [], ['CONTENT_TYPE' => 'application/json'], '   {"name": "Fanta", "stock": 100, "price": 2.00, "description": "limon" }' );
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertIsArray(json_decode($client->getResponse()->getContent(), true));
        }

        public function testCreateError(){
            $client = static::createClient();
            $client->request('POST', 'api/products');
            $this->assertEquals(400, $client->getResponse()->getStatusCode());
            $this->assertNull(json_decode($client->getResponse()->getContent(), true));
        }

        public function testShow(){
            $client = static::createClient();

            $productRepository = static::getContainer()->get(ProductsRepository::class);
            $product = $productRepository->findAll();   

            $client->request('GET', 'api/products/'.$products[0]->getId());

            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertIsArray(json_decode($client->getResponse()->getContent(), true));
        }

        public function testShowError(){
            $client = static::createClient();      
            $client->request('GET', 'api/products/50');
            $this->assertEquals(400, $client->getResponse()->getStatusCode());
            $this->assertNull(json_decode($client->getResponse()->getContent(), true));
        }

        public function testUpdate(){
            $client = static::createClient();

            $productRepository = static::getContainer()->get(ProductsRepository::class);
            $product = $productRepository->findAll();       

            $client->request('PUT', 'api/products/'.$products[1]->getId(),  [], [], ['CONTENT_TYPE' => 'application/json'], '   {"name": "Fanta", "stock": 100, "price": 2.00, "description": "naranjaa" }');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertIsArray(json_decode($client->getResponse()->getContent(), true));
        }

        public function testUpdateError(){
            $client = static::createClient();
            $client->request('PUT', 'api/products/50');
            $this->assertEquals(400, $client->getResponse()->getStatusCode());
            $this->assertNull(json_decode($client->getResponse()->getContent(), true));
        }

        public function testDelete(){
            $client = static::createClient();

            $productRepository = static::getContainer()->get(ProductsRepository::class);
            $product = $productRepository->findAll();   

            $client->request('DELETE', 'api/products/'.$products[1]->getId());
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertIsArray(json_decode($client->getResponse()->getContent(), true));
        }

        public function testDeleteError(){
            $client = static::createClient();
            $client->request('DELETE', 'api/products/{id}');
            $this->assertEquals(400, $client->getResponse()->getStatusCode());
            $this->assertNull(json_decode($client->getResponse()->getContent(), true));
        }
    }

?>