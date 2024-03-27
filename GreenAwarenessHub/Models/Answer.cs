using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
namespace GreenAwarenessHub.Models
{
    public class Answer
    {
        [Key]
        public int AnswerID { get; set; }

        [ForeignKey("Question")]
        public int QuestionID { get; set; }
        public Question Question { get; set; }

        
        public string ? AnswerText { get; set; }

       
        public bool IsCorrect { get; set; }
    }
}
