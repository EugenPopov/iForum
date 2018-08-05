<?php

namespace App\Tests;

use App\Entity\Users;
use App\Form\SearchForm;
use App\Form\UserType;
use App\Model\Search;
use Symfony\Component\Form\Test\TypeTestCase;

class FormTest extends TypeTestCase
{
    public function testSearchMessage()
    {
        $search_data=[
            'question' => 'q',
            'filter' => '1'
        ];

        $search = new Search();

        $form = $this->factory->create(SearchForm::class,$search);

        $form->submit($search_data);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($search,$form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($search_data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}