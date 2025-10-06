<?php

namespace App\Member\Application\Language;

use App\Member\Application\Language\Form\LanguageFormType;
use App\Member\Application\Language\Model\LanguageFormModel;
use App\Member\Application\Language\Model\LanguageListModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/language', name: 'language_')]
class LanguageController extends AbstractController
{
    public function __construct(private LanguageService $languageService) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function index(): Response
    {
        $arr = $this->languageService->getAll();
        $languages = array_map(fn($language) => new LanguageListModel(
            languageId: $language["languageId"],
            languageName: $language["languageName"],
            isActive: $language["isActive"]
        ), $arr);
        return $this->render('language/index.html.twig', [
        'languages' => $languages
    ]);
    }

    #[Route('/add', name: 'add', methods: ['GET','POST'])]
    public function add(Request $request): Response
    {
        $model = new LanguageFormModel();
        $form = $this->createForm(LanguageFormType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->languageService->add([
                'languageName' => $model->getLanguageName(),
                'isActive' => $model->isIsActive(),
                'isDeleted' => false,
            ]);
            $this->addFlash('success', 'Language added.');
            return $this->redirectToRoute('language_list');
        }

        return $this->render('language/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET','POST'])]
    public function edit(Request $request, int $id): Response
    {
        $data = $this->languageService->getById($id);
        $model = new LanguageFormModel();
        $model->setLanguageId($data['languageId'] ?? 0);
        $model->setLanguageName($data['languageName'] ?? '');
        $model->setIsActive($data['isActive'] ?? true);

        $form = $this->createForm(LanguageFormType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->languageService->update($id, [
                'languageName' => $model->getLanguageName(),
                'isActive' => $model->isIsActive(),
                'isDeleted' => false,
            ]);
            $this->addFlash('success', 'Language updated.');
            return $this->redirectToRoute('language_list');
        }

        return $this->render('language/edit.html.twig', [
            'form' => $form->createView(),
            'languageId' => $id,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        $this->languageService->delete($id);
        $this->addFlash('success', 'Language deleted.');
        return $this->redirectToRoute('language_list');
    }
}
