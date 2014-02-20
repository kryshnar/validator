<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Tests\Validator;

use Symfony\Component\Validator\DefaultTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Context\LegacyExecutionContextFactory;
use Symfony\Component\Validator\MetadataFactoryInterface;
use Symfony\Component\Validator\NodeVisitor\ContextUpdateVisitor;
use Symfony\Component\Validator\NodeVisitor\GroupSequenceResolvingVisitor;
use Symfony\Component\Validator\NodeVisitor\NodeValidationVisitor;
use Symfony\Component\Validator\NodeTraverser\NodeTraverser;
use Symfony\Component\Validator\Validator\LegacyValidator;

class LegacyValidatorLegacyApiTest extends AbstractLegacyApiTest
{
    protected function createValidator(MetadataFactoryInterface $metadataFactory)
    {
        $nodeTraverser = new NodeTraverser($metadataFactory);
        $nodeValidator = new NodeValidationVisitor($nodeTraverser, new ConstraintValidatorFactory());
        $contextFactory = new LegacyExecutionContextFactory($nodeValidator, new DefaultTranslator());
        $validator = new LegacyValidator($contextFactory, $nodeTraverser, $metadataFactory);
        $groupSequenceResolver = new GroupSequenceResolvingVisitor();
        $contextRefresher = new ContextUpdateVisitor();

        $nodeTraverser->addVisitor($groupSequenceResolver);
        $nodeTraverser->addVisitor($contextRefresher);
        $nodeTraverser->addVisitor($nodeValidator);

        return $validator;
    }
}
