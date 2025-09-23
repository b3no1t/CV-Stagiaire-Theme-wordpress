import typography from '@tailwindcss/typography'
// ! DEPRECATED IN TWCSS4
export default {
  content: [
    './theme/views/**/*.twig',
    './theme/blocks/**/*.twig',
  ],
  theme: {
    extend: {
      //
      /**
      * Configuration des familles de polices personnalisées
      * Chaque clé devient une classe utilitaire : font-heading, font-body, etc.
      */
      fontFamily: {
        // Police principale pour les titres et éléments d'emphasis
        'heading': [
          'sfpro-display',                      // Police personnalisée prioritaire
          'ui-sans-serif',              // Police système moderne (macOS/iOS)
          'system-ui',                  // Police système générique
          '-apple-system',              // Fallback Apple
          'BlinkMacSystemFont',         // Fallback Chrome/Edge
          'Segoe UI',                   // Fallback Windows
          'sans-serif'                  // Fallback générique final
        ],

        // Police pour le contenu textuel et la lecture longue
        'body': [
          'sfpro-normal',                      // Alternative moderne
          'ui-sans-serif',
          'system-ui',
          'sans-serif'
        ],

        // Police pour le code et éléments monospace
        'mono': [
          'JetBrains Mono',
          'Fira Code',                  // Police avec ligatures pour le code
          'ui-monospace',               // Monospace système
          'SFMono-Regular',             // Apple monospace
          'Monaco',                     // macOS fallback
          'Consolas',                   // Windows fallback
          'monospace'                   // Fallback générique
        ]
      },
      /**
       * Définition des poids de police disponibles
       * Permet d'utiliser font-light, font-medium, etc.
       */
      fontWeight: {
        'thin': '100',
        'extralight': '200',
        'light': '300',
        'normal': '400',
        'medium': '500',
        'semibold': '600',
        'bold': '700',
        'extrabold': '800',
        'black': '900'
      },
      /**
       * Tailles de police personnalisées avec gestion responsive
       * Utilise la fonction clamp() pour un scaling fluide
       */
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        // Tailles responsives avec clamp()
        'responsive-lg': ['clamp(1.125rem, 2.5vw, 1.5rem)', { lineHeight: '1.6' }],
        'responsive-xl': ['clamp(1.5rem, 4vw, 3rem)', { lineHeight: '1.2' }]
      }
      //
    }
  },
  plugins: [
    typography,
  ],
}
