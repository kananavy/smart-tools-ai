import { createI18n } from 'vue-i18n';

const messages = {
    en: {
        nav: {
            login: 'Login',
            getStarted: 'Get Started',
            features: 'Features',
            pricing: 'Pricing'
        },
        hero: {
            badge: 'Now with Llama 3.3 70B & Premium Tools',
            title: 'Unlock your potential with',
            titleHighlight: 'Intelligent AI Tools',
            subtitle: 'The all-in-one platform for content generation, summarization, and image analysis. Professional grade AI tools wrapped in a stunning interface.',
            ctaFree: 'Start Creating for Free',
            ctaDemo: 'View Demo'
        },
        stats: {
            dailyGenerations: 'Daily Generations',
            advancedTools: 'Advanced Tools',
            uptime: 'Uptime',
            aiAvailability: 'AI Availability'
        },
        features: {
            title: 'Powerful Tools Suite',
            subtitle: 'Everything you need to boost productivity',
            textGenerator: {
                title: 'Text Generator',
                desc: 'Create SEO-optimized blog posts, engaging social media captions, and professional emails in seconds.'
            },
            summarizer: {
                title: 'Smart Summarizer',
                desc: 'Condense long articles, reports, and documents into concise, easy-to-read executive summaries.'
            },
            imageAnalyzer: {
                title: 'Image Analysis',
                desc: 'Extract insights, text, and details from images using advanced computer vision technology.',
                new: 'New Feature'
            }
        },
        cta: {
            title: 'Ready to Supercharge Your Workflow?',
            subtitle: 'Join thousands of creators using SmartTools AI to build better content, faster. Start for free today.',
            button: 'Create Free Account',
            note: 'No credit card required for free plan'
        },
        footer: {
            rights: 'SmartTools AI. All rights reserved.'
        }
    },
    fr: {
        nav: {
            login: 'Connexion',
            getStarted: 'Commencer',
            features: 'Fonctionnalités',
            pricing: 'Tarifs'
        },
        hero: {
            badge: 'Maintenant avec Llama 3.3 70B & Outils Premium',
            title: 'Libérez votre potentiel avec',
            titleHighlight: 'des Outils IA Intelligents',
            subtitle: 'La plateforme tout-en-un pour la génération de contenu, le résumé et l\'analyse d\'images. Des outils IA professionnels dans une interface époustouflante.',
            ctaFree: 'Créer Gratuitement',
            ctaDemo: 'Voir la Démo'
        },
        stats: {
            dailyGenerations: 'Générations/Jour',
            advancedTools: 'Outils Avancés',
            uptime: 'Disponibilité',
            aiAvailability: 'Dispo IA 24/7'
        },
        features: {
            title: 'Suite d\'Outils Puissants',
            subtitle: 'Tout ce dont vous avez besoin pour booster votre productivité',
            textGenerator: {
                title: 'Générateur de Texte',
                desc: 'Créez des articles de blog optimisés SEO, des légendes sociales engageantes et des emails professionnels en quelques secondes.'
            },
            summarizer: {
                title: 'Résumé Intelligent',
                desc: 'Condensez de longs articles, rapports et documents en résumés exécutifs concis et faciles à lire.'
            },
            imageAnalyzer: {
                title: 'Analyse d\'Image',
                desc: 'Extrayez des informations, du texte et des détails à partir d\'images grâce à une vision par ordinateur avancée.',
                new: 'Nouveau'
            }
        },
        cta: {
            title: 'Prêt à booster votre flux de travail ?',
            subtitle: 'Rejoignez des milliers de créateurs utilisant SmartTools AI pour créer de meilleurs contenus, plus rapidement. Commencez gratuitement aujourd\'hui.',
            button: 'Créer un Compte Gratuit',
            note: 'Pas de carte de crédit requise'
        },
        footer: {
            rights: 'SmartTools AI. Tous droits réservés.'
        }
    }
};

const i18n = createI18n({
    legacy: false, // Usage with Composition API
    locale: 'en', // Default locale
    fallbackLocale: 'en',
    messages
});

export default i18n;
